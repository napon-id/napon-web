<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use DB;
use App\Faq;
use App\Province;
use App\Cities;
use App\Http\Controllers\Traits\Firebase;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Description;
use App\Article;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * use App\Http\Controllers\Traits\Firebase
     */
    use Firebase, RegistersUsers;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        // $this->email = request()->user()->getEmail();
        // $this->token = request()->bearerToken();
    }

    public function check(Request $request)
    {
        $user = $this->userDetail($request->uid);

        return $user->email;
    }

    /**
     * auth process. Create new user if authenticated user from firebase
     * does not has account on yet
     * 
     * @return Illuminate\Support\Facades\Request
     */
    public function auth(Request $request)
    {
        $message = '';

        $email = $request->email;
        // $email = request()->user()->getEmail();

        $user = User::where('email', '=', $email)->count();

        $password = $request->password ?? 'abcdef123456';

        if ($user < 1) {
            $createdUser = User::create([
                'name' => $email,
                'email' => $email,
                'password' => Hash::make($password)
            ]);

            if ($createdUser) {
                $createdUser->sendEmailVerificationNotification();
            }

            $message = 'User created successfully';
        } else {
            $message = 'User already has an account';
        }

        return response()->json([
            'message' => $message
        ]);
    }

    /**
     * login user through Api Post
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $message = '';
        $resultCode = 0;
        $userKey = NULL;

        if (!empty($request->user_email) && !empty($request->user_password)) {
            $email = $request->user_email;
            $password = $request->user_password;

            $auth = User::where('email', '=', $email)->first();
            if (!empty($auth)) {
                $checkPassword = Hash::check($password, $auth->password);

                if ($checkPassword) {
                    $resultCode = 4;
                    $message = 'Login Success';
                    $userKey = $auth->id;
                } else {
                    $resultCode = 1;
                    $message = 'Login failed, wrong email or password';
                }
            } else {
                $resultCode = 2;
                $message = 'User account not found';
            }
        } else {
            $resultCode = 2;
            $message = 'User account not found';
        }

        return response()->json([
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message,
            'user_key' => $userKey
        ]);
    }

    /**
     * register user through Api Post
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $message = '';
        $resultCode = 0;

        if (!empty($request->user_name) && !empty($request->user_email) && !empty($request->user_password)) {
            $createdUser = User::where('email', '=', $request->user_email)->count();
            if ($createdUser > 0) {
                $message = 'User already registered';
                $resultCode = 6;
            } else {
                $user = User::create([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'password' => Hash::make($request->user_password)
                ]);

                if ($user) {
                    $user->sendEmailVerificationNotification();
                    $message = 'Register Successful';
                    $resultCode = 5;
                }
            }
        } else {
            $message = 'Register failed';
            $resultCode = 6;
        }

        return response()->json([
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message,
            'user_data' => [
                'user_key' => $user->id ?? NULL,
                'user_email' => $user->email ?? NULL,
                'user_name' => $user->name ?? NULL
            ]
        ]);
    }

    // TODO: Add getUserEmail and check data from firebase-uid or user_id
    
    /**
     * return Faq
     * @return Illuminate\Http\Response
     */
    public function getFaq()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'faq_list' => Faq::query()->get(['question AS faq_question', 'answer AS faq_answer']),
        ]);
    }

    /**
     * get description
     * @return Illuminate\Http\Response
     */
    public function getDescription()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'description_list' => Description::query()->get(['img AS description_image', 'title AS description_title', 'text AS description_text'])
        ]);
    }

    /**
     * get user detail based on email
     * @return Illuminate\Http\Response
     */
    public function getUserDetail(Request $request)
    {
        $user = $this->userDetail($request->uid);
        $email = $user->email;
        // $email = 'akunbaru@mailinator.com';

        $user = DB::table('users')
            ->leftJoin( 'user_informations', 'users.id', '=', 'user_informations.user_id')
            ->leftJoin('cities', 'cities.id', '=', 'user_informations.city')
            ->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id')
            ->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('trees', 'trees.id', '=', 'products.tree_id')
            ->leftJoin('balances', 'balances.id', '=', 'users.id')
            ->select(
                DB::raw( 'users.name AS user_name'),
                DB::raw( 'users.email AS user_email'),
                DB::raw( 'user_informations.born_place AS user_birth_place'),
                DB::raw( 'user_informations.born_date AS user_birth_date'),
                DB::raw( 'user_informations.gender    AS user_sex'),
                DB::raw( '
                    (
                        CASE 
                            WHEN user_informations.gender = "1" 
                            THEN "Laki-Laki" 
                            ELSE "Wanita" 
                            END
                        ) AS user_sex'),
                DB::raw( 'user_informations.phone AS user_phone'),
                DB::raw( 'user_informations.address AS user_address'),
                DB::raw( 'cities.name AS user_city'),
                DB::raw( 'provinces.name AS user_state'),
                DB::raw( 'user_informations.postal_code AS user_zip_code'),
                DB::raw( 'user_informations.ktp AS user_id_number'),
                DB::raw( 'user_informations.user_image AS user_id_image'),
                DB::raw( 'SUM(products.tree_quantity) AS user_total_tree'),
                DB::raw( 'users.created_at AS user_join_date'),
                DB::raw( 'balances.balance AS user_balance'),
                DB::raw( '
                    SUM(trees.price) 
                    AS user_total_investment'),
                DB::raw( '
                    (
                        CASE 
                            WHEN users.email_verified_at IS NULL 
                            THEN "false" 
                            ELSE "true" 
                            END
                        ) AS user_email_verified')
            )
            ->where('users.email', '=', $email)
            ->groupBy(
                'users.id',
                'user_informations.id'
            )
            ->first();

        $banks = DB::table('users')
            ->rightJoin('accounts', 'accounts.user_id', '=', 'users.id')
            ->select(
                DB::raw('accounts.name AS user_bank_name'),
                DB::raw('accounts.number AS user_bank_account_number'),
                DB::raw('accounts.account_code AS user_bank_account_code'),
                DB::raw('accounts.number AS user_bank_account_name')
            )
            ->where('users.email', '=', $email)
            ->get();
            
        $user->user_banks = $banks;

        return response()->json([
            'request_code' => 200,
            'data' => $user,
            'result_code' => 4,
        ]);
    }

    /**
     * get user orders based on email
     * @return Illuminate\Http\Response
     */
    public function getUserOrder(Request $request)
    {
        $user = $this->userDetail($request->uid);
        $email = $user->email;
        // $email = request()->user()->getEmail();
        // $email = 'akunbaru@mailinator.com';

        $user = User::where('email', '=', $email)->first();

        $orders = DB::table( 'users')
            ->rightJoin( 'orders', 'orders.user_id', '=', 'users.id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('locations', 'locations.id', '=', 'orders.location_id')
            ->select(
                DB::raw( 'orders.token AS user_product_key'),
                DB::raw( 'products.created_at AS user_product_start_date'),
                DB::raw( 'locations.location AS user_product_location'),
                DB::raw( 'orders.updated_at AS user_product_harvest_date'),
                DB::raw( 'orders.status AS user_product_is_ready_to_harvest')
            )
            ->where('users.email', '=', $email)
            ->get();
        
        foreach ($orders as $order) {
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
            
            foreach ($reports as $report) {
                $displays = DB::table('displays')
                    ->select(
                        DB::raw( '
                            (
                                CASE 
                                    WHEN displays.is_video IS NULL 
                                    THEN "false" 
                                    ELSE "true" 
                                    END
                                ) AS video'),
                        DB::raw('displays.display_url AS display_url')
                    )
                    ->where('displays.report_id', '=', $report->id)
                    ->get();
                
                $report->display_list = $displays;
            }

            $order->report_list = $reports;
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
        return response()->json([
            'request_code' => 200,
            'result_code' => 4,
            'product_list' => $products,
        ]);
    }

    /**
     * return all provinces
     * @return Illuminate\Http\Response
     */
    public function getProvinces()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'province_list' => Province::all(),
        ]);
    }

    /**
     * get province detail based on province id
     * @return Illuminate\Http\Response
     */
    public function getProvinceDetail(Province $province)
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'province_detail' => $province,
        ]);
    }

    /**
     * get city list based on province id
     * @return Illuminate\Http\Response
     */
    public function getCities(Province $province)
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'city_list' => $province->cities()->get(),
        ]);
    }

    /**
     * get city detail based on city id
     * @return Illuminate\Http\Response
     */
    public function getCityDetail(Cities $city)
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'city_detail' => $city,
        ]);
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
     * get top article
     * 
     * @return Illuminate\Http\Response
     */
    public function getTopArticle()
    {
        $articles = Article::orderBy('statistic', 'desc')->paginate(5);
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'article_list' => $articles
        ]);
    }

    /**
     * get all article
     * 
     * @return Illuminate\Http\Response
     */
    public function getArticle()
    {
        $articles = DB::table('articles')
            ->select('articles.*')
            ->paginate(5);

        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'article_list' => $articles
        ]);
    }

    /**
     * get specific article and deails
     * 
     * @return Illuminate\Http\Response
     */
    public function getArticleDetail($id)
    {
        $article = Article::findOrFail($id);
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'article' => $article, [
                'article_detail' => $article->articleDetails()->get()
            ]           
        ]);
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

        return response()->json([
            'request_code' => 200,
            'result_code' => 4,
            'banner_list' => $banners
        ]);
    }

    /**
     * get User key
     * 
     * @param App\User
     * 
     * @return (array) key
     */
    protected function getUserKey(User $user)
    {
        $key = [];
        if ($user->firebase_uid != NULL) {
            $key['userKey'] = $user->firebase_uid; 
            $key['is_firebase'] = true;
        } else {
            $key['userKey'] = $user->id;
            $key['is_firebase'] = false;
        }

        return $key;
    }
}