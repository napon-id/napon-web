<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;
use App\Province;
use App\Description;
use App\Product;
use function GuzzleHttp\json_encode;
use App\Setting;
use DB;
use App\Order;
use App\Topup;

class GeneralController extends Controller
{
    public function getProduct()
    {
        $products = DB::table('products')
            ->join('trees', 'trees.id', '=', 'products.tree_id')
            ->select(
                DB::raw('products.id AS product_id'),
                DB::raw('products.name AS product_name'),
                DB::raw('products.tree_quantity AS product_tree_quantity'),
                DB::raw('products.img AS product_image_black'),
                DB::raw('products.secondary_img AS product_image_white'),
                DB::raw('products.img_android AS product_background'),
                DB::raw('products.simulation_img AS product_simulation'),
                DB::raw('products.description AS product_description'),
                DB::raw('CAST(products.tree_quantity AS unsigned) * CAST(trees.price AS unsigned) AS product_price'),
                DB::raw('
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
                    'result_code' => 9,
                    'request_code' => 200,
                    'message' => 'There is no data'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 7,
                'request_code' => 200,
                'message' => 'Bad request'
            ]);
        }
    }

    /**
     * get latest user activity
     * @return Illuminate\Http\Response
     */
    public function databaseStatus()
    {
        $lastProduct = Product::orderBy('updated_at', 'latest')->first();

        $lastDescription = Description::orderBy('updated_at', 'latest')->first();

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

        return response()->json($response, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
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
                DB::raw('banners.id AS banner_id'),
                DB::raw('banners.img AS banner_image'),
                DB::raw('banners.description AS banner_description')
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
     * get contact information
     *
     * @return Illuminate\Http\Response
     */
    public function getContact()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'contacts' => [
                'company_address' => Setting::where('key', 'contact_address')->first()->value,
                'company_email' => Setting::where('key', 'contact_email')->first()->value,
                'company_phone' => Setting::where('key', 'contact_phone')->first()->value,
                'company_website' => Setting::where('key', 'contact_website')->first()->value
            ]
        ]);
    }

    /**
     * retrieve midtrans payment notification 
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function midtransWebhook(Request $request)
    {
        $receivedData = $request->json()->all();
        
        $id = $receivedData['order_id'];
        $status = $receivedData['transaction_status'];

        // check if id is for order
        $order = Order::where('token', $id)->first();

        if (isset($order)) {
            if ($order->status == 1) { 
                if ($status == 'settlement') {
                    $order->status = 3;
                } else if ($status == 'failure' || $status == 'cancel') {
                    $order->status = 2;
                }
                $order->save();
            }
        } else {
            $topup = Topup::where('token', $id)->first();

            if (isset($topup)) {
                if ($topup->status == 1) {
                    if ($status == 'settlement') {
                        $topup->status = 2;
                    } else if ($status == 'failure' || $status == 'cancel') {
                        $topup->status = 3;
                    }
                    $topup->save();
                }
            }
        }

        return response()->json([
            'id' => $id,
            'response' => $receivedData
        ]);
    }
}
