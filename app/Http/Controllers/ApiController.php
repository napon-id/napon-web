<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use DB;
use App\Faq;
use App\Province;
use App\Http\Controllers\Traits\Firebase;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Description;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use App\Order;
use App\Setting;

class ApiController extends Controller
{
    /**
     * use App\Http\Controllers\Traits\Firebase
     */
    use Firebase, RegistersUsers;

    /**
     * return Faq
     *
     * @return Illuminate\Http\Response
     */
    public function getFaq()
    {
        $faq = Faq::query()->get(['question AS faq_question', 'answer AS faq_answer']);

        if ($faq) {
            return response()->json([
                'result_code' => 4,
                'request_code' => 200,
                'faq_list' => $faq
            ]);
        } else {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
    }

    /**
     * get description
     *
     * @return Illuminate\Http\Response
     */
    public function getDescription()
    {
        $description = Description::query()->get(['img AS description_image', 'title AS description_title', 'text AS description_text']);

        if ($description) {
            return response()->json([
                'result_code' => 4,
                'request_code' => 200,
                'description_list' => $description
            ]);
        } else {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
    }

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
            $order->user_product_is_ready_to_harvest = (bool) $order->user_product_is_ready_to_harvest;
            $order_id = DB::table('orders')
                ->select('orders.*')
                ->where('orders.token', '=', $order->user_product_key)
                ->first();

            $product = DB::table('products')
                ->select(
                    DB::raw( 'products.name AS product_name'),
                    DB::raw( 'products.img AS product_image_black')
                )
                ->where('products.id', '=', $order_id->product_id)
                ->first();
            $order->product = $product;

            $reports = DB::table('reports')
                ->select(
                    DB::raw( 'reports.id AS report_key'),
                    DB::raw( 'reports.period AS report_period'),
                    DB::raw( 'reports.start_date AS report_start_date'),
                    DB::raw( 'reports.end_date AS report_end_date'),
                    DB::raw( 'reports.tree_height AS report_tree_height'),
                    DB::raw( 'reports.tree_diameter AS report_tree_diameter'),
                    DB::raw( 'reports.tree_state AS report_tree_state'),
                    DB::raw( 'reports.weather AS report_weather'),
                    DB::raw( 'reports.roi AS report_roi')
                )
                ->where('reports.order_id', '=', $order_id->id)
                ->get();

            if ($reports) {
                foreach ($reports as $report) {
                    $displays = DB::table('displays')
                        ->select(
                            DB::raw( '
                                (
                                    CASE
                                        WHEN displays.is_video = 1
                                        THEN "true"
                                        ELSE "false"
                                        END
                                    ) AS video'),
                            DB::raw('displays.display_url AS display_url')
                        )
                        ->where('displays.report_id', '=', $report->report_key)
                        ->orderBy('displays.created_at', 'desc')
                        ->get();

                    $report->display_list = $displays;
                }

                $order->report_list = $reports;
            }


        }

        return response()->json([
            'request_code' => 200,
            'result_code' => 4,
            'data' => $orders,
        ]);
    }

    /**
     * get order detail based on token
     * @return Illuminate\Http\Response
     */
    public function getUserOrderDetail($token)
    {
        if ($token) {
            $details = DB::table( 'orders')
                ->rightJoin( 'order_updates', 'order_updates.order_id', '=', 'orders.id')
                ->select(
                    DB::raw('orders.token AS product_token'),
                    DB::raw('order_updates.description AS update_description'),
                    DB::raw('order_updates.created_at AS update_date')
                )
                ->where('orders.token', '=', $token)
                ->get();
        }

        return response()->json([
            'request_code' => 200,
            'result_code' => 4,
            'data' => $details
        ]);
    }

    public function getProduct()
    {
        $products = DB::table('products')
            ->join('trees', 'trees.id', '=', 'products.tree_id')
            ->select(
                DB::raw( 'products.id AS product_id'),
                DB::raw( 'products.name AS product_name'),
                DB::raw( 'products.tree_quantity AS product_tree_quantity'),
                DB::raw( 'products.img AS product_image_black'),
                DB::raw( 'products.secondary_img AS product_image_white'),
                DB::raw( 'products.img_android AS product_background'),
                DB::raw( 'products.simulation_img AS product_simulation'),
                DB::raw( 'products.description AS product_description'),
                DB::raw( 'CAST(products.tree_quantity AS unsigned) * CAST(trees.price AS unsigned) AS product_price'),
                DB::raw( '
                (
                        CASE
                            WHEN products.has_certificate = "1"
                            THEN "true"
                            ELSE "false"
                            END
                        ) AS product_has_certificate')
            )
            ->get();
        
        if ($products) {
            return response()->json([
                'request_code' => 200,
                'result_code' => 4,
                'product_list' => $products,
            ]);
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 9,
                'message' => 'There is no data'
            ]);
        }
    }

    /**
     * return all provinces
     * @return Illuminate\Http\Response
     */
    public function getProvinces()
    {
        $provinces = Province::get([
            'id AS province_id',
            'name AS province_name'
        ]);

        if ($provinces) {
            return response()->json([
                'result_code' => 4,
                'request_code' => 200,
                'province_list' => $provinces
            ]);
        } else {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
    }

    /**
     * get city list based on province id
     * @return Illuminate\Http\Response
     */
    public function getCities(Request $request)
    {
        if ($request->has('province_id')) {

            $province = Province::find($request->province_id);

            if ($province) {
                return response()->json([
                    'result_code' => 4,
                    'request_code' => 200,
                    'city_list' => $province->cities()->get([
                        'id AS city_id',
                        'name AS city_name'
                    ]),
                ]);
            } else {
                return response()->json([
                    'result_code' => 7,
                    'request_code' => 200,
                    'message' => 'Data not found'
                ]);
            }

        } else {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
    }

    /**
     * get latest user activity
     * @return Illuminate\Http\Response
     */
    public function databaseStatus()
    {
        $lastProduct = Product::latest()->first();

        $lastDescription = Description::latest()->first();

        return response()->json([
            'request_code' => 200,
            'db_status' => [
                'product_last_update' => $lastProduct->updated_at->format('Y-m-d h:i:s'),
                'description_last_update' => $lastDescription->created_at->format('Y-m-d h:i:s')
            ]
        ]);
    }

    /**
     * get term and condition
     *
     * @return Illuminate\Http\Response
     */
    public function getTermAndCondition()
    {
        $termAndCondition = Setting::where('key', 'term_and_condition')->first();
        $data = $termAndCondition->value;
        $jsonData = json_encode($data);

        $response = [];
        $response['result_code'] = 4;
        $response['request_code'] = 200;
        $response['message'] = $data;

        return response()->json($response, 200, [], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);
    }

    /**
     * get banners
     *
     * @return Illuminate\Http\Response
     */
    public function getBanner()
    {
        $banners = DB::table('banners')
            ->select(
                DB::raw( 'banners.id AS banner_id'),
                DB::raw( 'banners.img AS banner_image'),
                DB::raw( 'banners.description AS banner_description')
            )
            ->get();

        if ($banners) {
            return response()->json([
                'request_code' => 200,
                'result_code' => 4,
                'banner_list' => $banners
            ]);
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 9,
                'message' => 'There is no data'
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

        $email = $this->getUserEmail($request->user_key);
        $product = $request->user_order;

        $user = User::where('email', $email)->first();

        if ($user) {
            $productQuery = Product::where('name', '=', $product)->first();

            if ($productQuery) {
                $order = Order::create([
                    'token' => base64_encode(now()),
                    'user_id' => $user->id,
                    'product_id' => $productQuery->id
                ]);

                if ($order) {
                    $resultCode = 4;
                    $message = 'Product ordered successfully';

                    $user_order = (object) array();

                    $user_order->product_name = $productQuery->name;
                    $user_order->product_price = (double) $productQuery->tree_quantity * $productQuery->tree->price;
                    $user_order->product_tree_quantity = (int) $productQuery->tree_quantity;
                }
            } else {
                $resultCode = 4;
                $message = 'Product not found';
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

        if ($user_order) {
            $response['user_order'] = $user_order;
        }

        return response()->json($response);
    }
}