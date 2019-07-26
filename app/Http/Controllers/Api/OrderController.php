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
use App\Http\Controllers\Traits\MidTrans;
use App\ProductReplicate;
use App\SimulationReplicate;
use App\Transaction;
use App\Http\Controllers\Traits\UserData;

class OrderController extends Controller
{
    use Firebase, UserApi, MidTrans, UserData;

    /**
     * get user orders based on email
     *
     * @return Illuminate\Http\Response
     */
    public function getUserOrder(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail($request->user_key);

            if ($email == '') {
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

        $userData = $this->getUserData(User::where('email', $email)->first());

        if (!$userData['user_email_verified']) {
            return response()->json([
                'request_code' => 200,
                'result_code' => 16,
                'message' => 'Verify your email address before continue'
            ]);
        }

        if (!$userData['user_data_filled']) {
            return response()->json([
                'request_code' => 200,
                'result_code' => 17,
                'message' => 'Fill all personal information before continue'
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
            ->select(
                DB::raw('orders.token AS user_product_key'),
                DB::raw('orders.created_at AS user_product_start_date'),
                DB::raw('
                    CASE
                        WHEN orders.status = 4 THEN 1
                        ELSE 0
                    END AS user_product_status
                '),
                DB::raw('orders.img_certificate AS user_product_sertificate')
            )
            ->where('users.email', '=', $email)
            ->where('orders.status', '!=', '1')
            ->where('orders.status', '!=', '2')
            ->limit($dataPerPage)
            ->offset($offset)
            ->get();

        if ($orders->count() < 1) {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
        
        foreach ($orders as $order) {
            $order_data = DB::table('orders')
                ->select('orders.*')
                ->where('orders.token', '=', $order->user_product_key)
                ->first();
            
            // product
            $product = DB::table('product_replicates')
                ->select([
                    'product_replicates.name AS product_name',
                    'product_replicates.img_black AS product_image_black'
                ])
                ->where('product_replicates.id', '=', $order_data->product_id)
                ->first();
            
            $order->product = $product;
            
            // location
            $location = DB::table('locations')
                ->select([
                    DB::raw('location AS location_name'),
                    DB::raw('lat AS latitude'),
                    DB::raw('lng AS longitude')
                ])
                ->where('locations.id', '=', $order_data->id)
                ->first();
            
            if (isset($location)) {
                // cast variables
                $location->latitude = (double) $location->latitude;
                $location->longitude = (double) $location->longitude;

                $order->location = $location;
            } else {
                $order->location = NULL;
            }

            // report list
            $report = DB::table('reports')
                ->select([
                    'reports.report_key AS report_key',
                    'reports.period AS report_period',
                    'reports.start_date AS report_start_date',
                    'reports.end_date AS report_end_date',
                    'reports.tree_height AS report_tree_height',
                    'reports.tree_diameter AS report_tree_diameter',
                    'reports.tree_state AS report_tree_state',
                    'reports.weather AS report_weather',
                    'reports.report_image AS report_image',
                    'reports.report_video AS report_video'
                ])
                ->where('reports.order_id', '=', $order_data->id)
                ->get();

            foreach ($report as $data) {
                $data->report_tree_height = (double) $data->report_tree_height;
                $data->report_tree_diameter = (double) $data->report_tree_diameter;
            }

            $order->report_list = $report;
        }

        $user = User::where('email', $email)->first();

        return response()->json([
            'request_code' => 200,
            'result_code' => 4,
            'user_product_list' => $orders,
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
        if ($request->has('user_key') && $request->user_key != '') {
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

                $userData = $this->getUserData($user);

                if (!$userData['user_email_verified']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 16,
                        'message' => 'Verify your email address before continue'
                    ]);
                }

                if (!$userData['user_data_filled']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 17,
                        'message' => 'Fill all personal information before continue'
                    ]);
                }

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
                
                if ($orders->count() < 1) {
                    return response()->json([
                        'result_code' => 9,
                        'request_code' => 200,
                        'message' => 'There is no data'
                    ]);
                }
                
                foreach ($orders as $order) {
                    $product = Order::where('token', $order->transaction_id)
                        ->first()
                        ->product()
                        ->first();

                    $order_data = Order::where('token', $order->transaction_id)
                        ->first();

                    $product_array = [
                        'product_name' => $product->name,
                        'product_image_black' => $product->img_black,
                    ];
                    // $order->transaction_number = 'NAPON-' .  sprintf("%'03d", $order_data->id);
                    $order->transaction_number = $order_data->transaction->queue;
                    $order->transaction_va_number = $order_data->transaction->payment_number;
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
     * create transaction to check existing user transaction
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function orderTransaction(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail($request->user_key);

            if ($email != '') {
                $user = User::where('email', $email)->first();

                $userData = $this->getUserData($user);

                if (!$userData['user_email_verified']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 16,
                        'message' => 'Verify your email address before continue'
                    ]);
                }

                if (!$userData['user_data_filled']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 17,
                        'message' => 'Fill all personal information before continue'
                    ]);
                }

                if ($request->has('user_order') && $request->user_order != '') {
                    $product = Product::where('name', $request->user_order)->first();

                    if (isset($product)) {
                        $unfinishedOrder = Order::where('status', 1)
                            ->where('user_id', $user->id)
                            ->get();

                        if ($unfinishedOrder->count() < 1) {
                            $transaction = Transaction::create([
                                'user_id' => $user->id,
                                'queue' => 'NAPON-' . (2019 + Transaction::get()->count())
                            ]);

                            return response()->json([
                                'request_code' => 200,
                                'result_code' => 4,
                                'transaction_data' => [
                                    'transaction_number' => $transaction->queue,
                                    'transaction_key' => md5($transaction->id),
                                    'transaction_total_payment' => $product->price
                                ]
                            ]);
                        } else {
                            return response()->json([
                                'request_code' => 200,
                                'result_code' => 15,
                                'message' => 'Please finish existing transaction'
                            ]);
                        }
                    }  else {
                        return response()->json([
                            'request_code' => 200,
                            'result_code' => 7,
                            'message' => 'Bad request'
                        ]);
                    }
                } else {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 9,
                        'message' => 'There is no data'
                    ]);
                }
            } else {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2,
                    'message' => 'User not found'
                ]);
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'message' => 'User not found'
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
            $userData = $this->getUserData($user);

            if (!$userData['user_email_verified']) {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 16,
                    'message' => 'Verify your email address before continue'
                ]);
            }

            if (!$userData['user_data_filled']) {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 17,
                    'message' => 'Fill all personal information before continue'
                ]);
            }

            $productQuery = Product::where('name', '=', $product)->first();

            if ($productQuery) {
                $replicatedProduct = $this->replicateProductAndSimulation($productQuery);
                $unfinishedOrder = Order::where('status', 1)
                    ->where('user_id', $user->id)
                    ->first();

                if (isset($unfinishedOrder)) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 15,
                        'message' => 'Please finish existing transaction'
                    ]);
                } else {
                    $order = Order::create([
                        'token' => md5('Order-' . now()),
                        'user_id' => $user->id,
                        'product_id' => $replicatedProduct->id,
                        'buy_price' => $replicatedProduct->price
                    ]);

                    // midrans payment
                    $res = $this->orderMidTrans($order);
                    $result = json_decode($res->getBody());
                    $va_number = $result->va_numbers[0]->va_number;

                    $transaction = Transaction::where('user_id', $user->id)
                        ->whereNull('order_id')
                        ->latest()
                        ->first();
                    
                    if (!isset($transaction)) {
                        $transaction = Transaction::create([
                            'user_id' => $user->id,
                            'queue' => 'NAPON-' . (2019 + Transaction::get()->count()),
                            'order_id' => $order->id,
                            'payment_number' => $va_number
                        ]);
                    } else {
                        $transaction->update([
                            'order_id' => $order->id,
                            'payment_number' => $va_number
                        ]);
                    }
    
                    if ($order) {
                        $resultCode = 4;
                        $message = 'Order success';
                        $transaction_data = [
                            'transaction_number' => $order->transaction->queue,
                            'transaction_key' => $order->token,
                            'transaction_total_payment' => (double) $replicatedProduct->price,
                            'transaction_va_number' => $va_number
                        ];
                    }
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

        if (isset($transaction_data)) {
            $response['transaction_data'] = $transaction_data;
        }

        return response()->json($response);
    }

    /**
     * create user order by balance
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function orderProductByBalance(Request $request)
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
            $userData = $this->getUserData($user);

            if (!$userData['user_email_verified']) {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 16,
                    'message' => 'Verify your email address before continue'
                ]);
            }

            if (!$userData['user_data_filled']) {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 17,
                    'message' => 'Fill all personal information before continue'
                ]);
            }
            
            $productQuery = Product::where('name', '=', $product)->first();

            if ($productQuery) {
                $replicatedProduct = $this->replicateProductAndSimulation($productQuery);
                $needPaid = (double) $productQuery->price;
                $balance = (double) $user->balance->balance;
                
                // check current user balance
                if ($balance >= $needPaid) {
                    $unfinishedOrder = Order::where('status', 1)->first();

                    if (isset($unfinishedOrder)) {
                        return response()->json([
                            'request_code' => 200,
                            'result_code' => 15,
                            'message' => 'Please finish existing transaction'
                        ]);
                    } else {
                        $order = Order::create([
                            'token' => md5('Order-' . now()),
                            'user_id' => $user->id,
                            'product_id' => $replicatedProduct->id,
                            'buy_price' => (int) $replicatedProduct->price,
                            'status' => 3
                        ]);
    
                        // decrement user balance
                        $user->balance->decrement('balance', $needPaid);

                        $transaction = Transaction::where('user_id', $user->id)
                            ->whereNull('order_id')
                            ->latest()
                            ->first();

                        if (!isset($transaction)) {
                            $transaction = Transaction::create([
                                'user_id' => $user->id,
                                'queue' => 'NAPON-' . (2019 + Transaction::get()->count()),
                                'order_id' => $order->id
                            ]);
                        } else {
                            $transaction->update([
                                'order_id' => $order->id
                            ]);
                        }

                    }
                } else {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 11,
                        'message' => 'Insufficient balance'
                    ]);
                }

                if (isset($order)) {
                    $resultCode = 4;
                    $message = 'Product ordered successfully';

                    $resultCode = 4;
                    $message = 'Order success';
                    $transaction_data = [
                        'transaction_number' => $order->transaction->queue,
                        'transaction_key' => $order->token,
                        'transaction_total_payment' => (double) $replicatedProduct->price
                    ];
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

        if (isset($transaction_data)) {
            $response['transaction_data'] = $transaction_data;
        }

        return response()->json($response);
    }

    /**
     * replicate product
     * 
     * @param App\Product $product
     * 
     * @return App\ProductReplicate $replicatedProduct
     */
    protected function replicateProductAndSimulation(Product $product)
    {
        $replicatedProduct = ProductReplicate::create([
            'tree_id' => $product->tree_id,
            'name' => $product->name,
            'tree_quantity' => $product->tree_quantity,
            'description' => $product->description,
            'available' => $product->available,
            'price' => $product->price,
            'img_black' => $product->img_black,
            'img_white' => $product->img_white,
            'img_background' => $product->img_background
        ]);

        if ($replicatedProduct) {
            foreach ($product->simulations()->get() as $simulation) {
                SimulationReplicate::create([
                    'product_id' => $replicatedProduct->id,
                    'year' => $simulation->year,
                    'min' => $simulation->min,
                    'max' => $simulation->max
                ]);
            }
        }

        return $replicatedProduct;
    }
}
