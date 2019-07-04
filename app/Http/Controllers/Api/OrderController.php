<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Firebase;
use App\Http\Controllers\Traits\UserApi;
use App\Product;
use App\Order;
use App\User;
use DB;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    use Firebase, UserApi;

    /**
     * get user orders based on email
     *
     * @return Illuminate\Http\Response
     */
    public function getUserOrder(Request $request)
    {
        if ($request->has('user_key')) {
            $email = $this->getUserEmail($request->user_key);

            if (!$email) {
                return response()->json([
                    'result_code' => 2,
                    'request_code' => 200,
                    'message' => 'User not found'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }

        // initialize variables
        $dataPerPage = $offset = 0;
        $page = 1;

        if ($request->has('count_per_page')) {
            $dataPerPage = $request->count_per_page;
        } else {
            $dataPerPage = 5;
        }

        if ($request->has('page')) {
            $page = $request->page;
            $offset = ($page - 1) * $dataPerPage;
        } else {
            $offset = ($page - 1) * $dataPerPage;
        }

        $orders = DB::table('users')
            ->rightJoin('orders', 'orders.user_id', '=', 'users.id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('locations', 'locations.id', '=', 'orders.location_id')
            ->select(
                DB::raw('orders.token AS user_product_key'),
                DB::raw('products.created_at AS user_product_start_date'),
                DB::raw('locations.location AS user_product_location'),
                DB::raw('orders.updated_at AS user_product_harvest_date'),
                DB::raw('
                    (CASE
                        WHEN orders.status = "done"
                        THEN true
                        ELSE false
                        END
                    ) AS user_product_is_ready_to_harvest
                ')
            )
            ->where('users.email', '=', $email)
            ->limit($dataPerPage)
            ->offset($offset)
            ->get();

        foreach ($orders as $order) {
            $order->user_product_is_ready_to_harvest = (bool)$order->user_product_is_ready_to_harvest;
            $order_id = DB::table('orders')
                ->select('orders.*')
                ->where('orders.token', '=', $order->user_product_key)
                ->first();

            $product = DB::table('products')
                ->select(
                    DB::raw('products.name AS product_name'),
                    DB::raw('products.img AS product_image_black')
                )
                ->where('products.id', '=', $order_id->product_id)
                ->first();
            $order->product = $product;

            $reports = DB::table('reports')
                ->select(
                    DB::raw('reports.id AS report_key'),
                    DB::raw('reports.period AS report_period'),
                    DB::raw('reports.start_date AS report_start_date'),
                    DB::raw('reports.end_date AS report_end_date'),
                    DB::raw('reports.tree_height AS report_tree_height'),
                    DB::raw('reports.tree_diameter AS report_tree_diameter'),
                    DB::raw('reports.tree_state AS report_tree_state'),
                    DB::raw('reports.weather AS report_weather'),
                    DB::raw('reports.roi AS report_roi'),
                    DB::raw('reports.report_image AS report_image'),
                    DB::raw('reports.report_video AS report_video')
                )
                ->where('reports.order_id', '=', $order_id->id)
                ->get();

            if ($reports) {
                $order->report_list = $reports;
            }
        }

        return response()->json([
            'request_code' => 200,
            'result_code' => 4,
            'product_list' => $orders,
        ]);
    }

    /**
     * get user transactions (all user orders)
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function getUserTransactions(Request $request)
    {
        if ($request->has('user_key')) {
            $email = $this->getUserEmail((string) $request->user_key);

            if ($email == '') {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2,
                    'data' => [
                        'message' => 'User not found'
                    ]
                ]);
            } else {
                $user = User::where('email', $email)->first();

                $orders = DB::table('orders')
                    ->select([
                        DB::raw('orders.token AS transaction_id'),
                        DB::raw('orders.created_at AS transaction_date'),
                        DB::raw('orders.status AS transaction_status'),
                        DB::raw('orders.buy_price AS transaction_total_payment')
                    ])
                    ->orderBy('orders.created_at', 'DESC')
                    ->where('orders.user_id', '=', $user->id)
                    ->get();
                
                foreach ($orders as $order) {
                    $product = Order::where('token', $order->transaction_id)
                        ->first()
                        ->product()
                        ->first();
                    $product_array = [
                        'product_name' => $product->name,
                        'product_image_black' => $product->img,
                    ];
                    $order->transaction_number = 'NAPON-' .  sprintf("%'03d", $product->id);
                    $order->product = $product_array;
                }

                return response()->json([
                    'result_code' => 4,
                    'request_code' => 200,
                    'transaction_list' => $orders
                ]);
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }
    }

    /**
     * create user order process
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function orderProduct(Request $request)
    {
        $message = '';
        $resultCode = 0;

        if ($request->has('user_key')) {
            $email = $this->getUserEmail($request->user_key);
            $user = User::where('email', $email)->first();
        }

        if ($request->has('user_order')) {
            $product = $request->user_order;
        } else {
            $product = '';
        }

        if (isset($user)) {
            $productQuery = Product::where('name', '=', $product)->first();

            if ($productQuery) {
                $order = Order::create([
                    'token' => md5(now()),
                    'user_id' => $user->id,
                    'product_id' => $productQuery->id,
                    'buy_price' => (int) $productQuery->tree_quantity * $productQuery->tree->price
                ]);

                $res = $this->requestMidTrans($order);

                $result = json_decode($res->getBody());

                if ($order) {
                    $resultCode = 4;
                    $message = 'Product ordered successfully';

                    $user_order = (object)array();

                    $user_order->product_name = $productQuery->name;
                    $user_order->product_price = (double)$productQuery->tree_quantity * $productQuery->tree->price;
                    $user_order->product_tree_quantity = (int)$productQuery->tree_quantity;

                    // midtrans
                    $user_order->midtrans = $result;
                }
            } else {
                $resultCode = 9;
                $message = 'There is no data';
            }
        } else {
            $resultCode = 2;
            $message = 'User account not found';
        }

        $response = [
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message
        ];

        if (isset($user_order)) {
            $response['user_order'] = $user_order;
        }

        return response()->json($response);
    }

    protected function requestMidTrans(\App\Order $order)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
            'auth' => [
                'SB-Mid-server-2qBPvk5TYHAsxZIBOM4qYPln',
                ''
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'payment_type' => 'echannel',
                'transaction_details' => [
                    'gross_amount' => $order->product->tree_quantity * $order->product->tree->price,
                    'order_id' => $order->token
                ],
                'customer_details' => [
                    'email' => $order->user->email,
                    'phone' => $order->user->userInformation->phone
                ],
                'item_details' => [
                    'id' => $order->product->name,
                    'price' => $order->product->tree->price,
                    'quantity' => $order->product->tree_quantity,
                    'name' => $order->product->tree->name
                ],
                'echannel' => [
                    'bill_info1' => 'Payment',
                    'bill_info2' => $order->product->name
                ]
            ]
        ]);

        return $res;
    }
}
