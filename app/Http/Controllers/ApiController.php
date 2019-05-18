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
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\json_encode;
use App\Order;
use App\Account;

class ApiController extends Controller
{
    /**
     * use App\Http\Controllers\Traits\Firebase
     */
    use Firebase, RegistersUsers;

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
                    $userKey = base64_encode($auth->email);
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

        $validator = Validator::make($request->all(), [
            'user_name' => 'required|max:191|regex:/^(\pL+\s?)*\s*$/',
            'user_email' => 'required|email|unique:users,email|max:191',
            'user_password' => 'required|string|min:6|alpha_num'
        ]);

        if ($validator->fails()) {
            $errors = (object) array();
            $validatorMessage = $validator->getMessageBag()->toArray();

            isset($validatorMessage['user_name']) ? ($errors->user_name = $validatorMessage['user_name'][0]) : $errors;
            isset($validatorMessage['user_email']) ? ($errors->user_email = $validatorMessage['user_email'][0]) : $errors;
            isset($validatorMessage['user_password']) ? ($errors->user_password = $validatorMessage['user_password'][0]) : $errors;
            
            return response()->json([
                'result_code' => 6,
                'request_code' => 200,
                'errors' => $errors
            ]);
        }

        $user = User::create([
            'name' => rtrim( ltrim( $request->user_name)),
            'email' => $request->user_email,
            'password' => Hash::make($request->user_password)
        ]);

        if ($user) {
            $user->sendEmailVerificationNotification();
            $message = 'Register Successful';
            $resultCode = 5;
        }

        return response()->json([
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message
            // 'user_data' => [
            //     'user_key' => base64_encode($user->email) ?? NULL,
            //     'user_email' => $user->email ?? NULL,
            //     'user_name' => $user->name ?? NULL
            // ]
        ]);
    }
    
    /**
     * return Faq
     * 
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
     * 
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
        $email = $this->getUserEmail((string) $request->user_key);

        if ($email == '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }

        // check if registered user does not have User data
        $userData = User::where('email', $email)->count();

        if ($userData < 1) {
            $user = User::create([
                'name' => $email,
                'email' => $email,
                'password' => Hash::make('katakunci123'),
                'firebase_uid' => (string) $request->user_key
            ]);

            if ($user) {
                $user->sendEmailVerificationNotification();
            }
        }

        $user = DB::table('users')
            ->leftJoin( 'user_informations', 'users.id', '=', 'user_informations.user_id')
            ->leftJoin( 'cities', 'cities.id', '=', 'user_informations.city')
            ->leftJoin( 'provinces', 'provinces.id', '=', 'cities.province_id')
            ->leftJoin( 'orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin( 'products', 'products.id', '=', 'orders.product_id')
            ->leftJoin( 'trees', 'trees.id', '=', 'products.tree_id')
            ->leftJoin( 'balances', 'balances.id', '=', 'users.id')
            ->select(
                DB::raw( 'users.name AS user_name'),
                DB::raw( 'users.email AS user_email'),
                DB::raw( 'user_informations.user_image AS user_image'),
                DB::raw( 'user_informations.born_place AS user_birth_place'),
                DB::raw( 'user_informations.born_date AS user_birth_date'),
                DB::raw( 'user_informations.gender AS user_sex'),
                DB::raw( '
                    (
                        CASE 
                            WHEN user_informations.gender = "1" 
                            THEN "Laki-Laki" 
                            WHEN user_informations.gender = "2"
                            THEN "Wanita"
                            ELSE null 
                            END
                        ) AS user_sex'),
                DB::raw( 'user_informations.phone AS user_phone'),
                DB::raw( 'user_informations.address AS user_address'),
                DB::raw( 'cities.name AS user_city'),
                DB::raw( 'provinces.name AS user_state'),
                DB::raw( 'user_informations.postal_code AS user_zip_code'),
                DB::raw( 'user_informations.ktp AS user_id_number'),
                DB::raw( 'user_informations.user_id_image AS user_id_image'),
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
                DB::raw('accounts.number AS user_bank_account_name')
            )
            ->where('users.email', '=', $email)
            ->get();
        
            
            if ($user) {
                $user->user_banks = $banks;
                
                // cast string to other data type
                $user->user_id_number = (int) $user->user_id_number;
                $user->user_zip_code = (int) $user->user_zip_code;
                $user->user_balance = (double) $user->user_balance;
                $user->user_total_tree = (int) $user->user_total_tree;
                $user->user_total_investment = (double) $user->user_total_investment;
        }

        return response()->json([
            'request_code' => 200,
            'data' => $user,
            'result_code' => 4,
        ]);
    }

    /**
     * update user data
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function updateUserDetail(Request $request)
    {
        /**
         * request param && mapping
         * - user_name => user->name
         * - user_image => userInformation->user_image
         * - user_birth_place => userInformation->born_place
         * - user_sex => userInformation->gender
         * - user_phone => userInformation->phone
         * - user_address => userInformation->address
         * - user_city => userInformation->city
         * - user_state => userInformation->province
         * - user_zip_code => userInformation->postal_code
         * - user_id_number => userInformation->ktp
         * - user_id_image => userInformation->user_id_image
         *  
         */
        $email = $this->getUserEmail((string) $request->user_key);

        if ($email == '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }

        $user = User::where('email', $email)->first();

        $user->update([
            'name' => $request->user_name ?? $user->name
        ]);
        
        $userInformation = $user->userInformation()->first();
        
        $userInformation->update([
            // 'user_image' => $request->user_image ?? $userInformation->user_image,
            'born_place' => $request->user_birth_place ?? $userInformation->born_place,
            'born_date' => $request->user_born_date ?? $userInformation->born_date,
            'gender' => $request->user_sex ?? $userInformation->gender,
            'phone' => $request->user_phone ?? $userInformation->phone,
            'address' => $request->user_address ?? $userInformation->address,
            'city' => $request->user_city ?? $userInformation->city,
            'province' => $request->user_state ?? $userInformation->province,
            'postal_code' => $request->user_zip_code ?? $userInformation->postal_code,
            'ktp' => $request->user_id_number ?? $userInformation->ktp
            // 'user_id_image' => $request->user_id_image ?? $userInformation->user_id_image
        ]);

        return response()->json([
            'result_code' => 3,
            'request_code' => 200,
            'data' => [
                'message' => 'There is change on user profile, update user local data'
            ]
        ]);
    }

    /**
     * get user orders based on email
     * @return Illuminate\Http\Response
     */
    public function getUserOrder(Request $request)
    {
        $email = $this->getUserEmail($request->user_key);

        if ($request->has('page')) {
            $page = $request->page;
            if ($request->has('count_per_page')) {
                $dataPerPage = $request->data_per_page;
            } else {
                $dataPerPage = 5;
            }
            $offset = ($page - 1) * $dataPerPage;
            $orders = DB::table('users')
                ->rightJoin('orders', 'orders.user_id', '=', 'users.id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->leftJoin('locations', 'locations.id', '=', 'orders.location_id')
                ->select(
                    DB::raw('orders.token AS user_product_key'),
                    DB::raw('products.created_at AS user_product_start_date'),
                    DB::raw('locations.location AS user_product_location'),
                    DB::raw('orders.updated_at AS user_product_harvest_date'),
                    DB::raw('orders.status AS user_product_is_ready_to_harvest')
                )
                ->where('users.email', '=', $email)
                ->offset(5)
                ->get();
        } else {
            $orders = DB::table('users')
                ->rightJoin('orders', 'orders.user_id', '=', 'users.id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->leftJoin('locations', 'locations.id', '=', 'orders.location_id')
                ->select(
                    DB::raw('orders.token AS user_product_key'),
                    DB::raw('products.created_at AS user_product_start_date'),
                    DB::raw('locations.location AS user_product_location'),
                    DB::raw('orders.updated_at AS user_product_harvest_date'),
                    DB::raw('orders.status AS user_product_is_ready_to_harvest')
                )
                ->where('users.email', '=', $email)
                ->get();
        }
        
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
    public function getTopArticle(Request $request)
    {
        $articles = Article::orderBy('statistic', 'desc')
            ->limit(5)
            ->get($this->getArticleArray());

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
    public function getArticle(Request $request)
    {
        // initialize variables
        $page = $dataPerPage = $offset = 0;

        if ($request->has('count_per_page')) {
            $dataPerPage = $request->data_per_page;
        } else {
            $dataPerPage = 5;
        }

        if ($request->has('page')) {
            $page = $request->page;
            $offset = ($page - 1) * $dataPerPage;
        } 

        if ($dataPerPage > 0 && $page > 0 && $offset > 0) {
            $articles = Article::orderBy('id', 'asc')->limit($dataPerPage)->offset($offset)->get($this->getArticleArray());
        } else {
            $articles = Article::orderBy('id', 'asc')->get($this->getArticleArray());
        }

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

        $article->article_detail = $article->articleDetails()->get(['title AS sub_title', 'img AS sub_image', 'description AS sub_description']);

        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'article' => $article
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
                }
            } else {
                $resultCode = 4;
                $message = 'Product not found';
            }

        } else {
            $resultCode = 2;
            $message = 'User account not found';
        }

        return response()->json([
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message
        ]);
    }

    /**
     * add user bank data
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function userAddBank(Request $request)
    {
        $email = $this->getUserEmail($request->user_key);

        $user = User::where('email', $email)->first();

        if ($user) {
            $validator = Validator::make($request->all(), [
                'user_bank_name' => 'required|string|max:191',
                'user_bank_account_name' => 'required|string|max:191',
                'user_bank_account_number' => 'required|numeric|digits_between:10,15'
            ]);

            if ($validator->fails()) {
                $errors = (object)array();
                $validatorMessage = $validator->getMessageBag()->toArray();

                isset($validatorMessage['user_bank_name']) ? ($errors->user_name = $validatorMessage['user_bank_name'][0]) : $errors;
                isset($validatorMessage['user_bank_account_name']) ? ($errors->user_email = $validatorMessage['user_bank_account_name'][0]) : $errors;
                isset($validatorMessage['user_bank_account_number']) ? ($errors->user_password = $validatorMessage['user_bank_account_number'][0]) : $errors;

                return response()->json([
                    'result_code' => 6,
                    'request_code' => 200,
                    'errors' => $errors
                ]);
            }
    
            $account = Account::create([
                'user_id' => $user->id,
                'name' => $request->user_bank_name,
                'holder_name' => $request->user_bank_account_name,
                'number' => $request->user_bank_account_name
            ]);
    
            if ($account) {
                return response()->json([
                    'result_code' => 4,
                    'request_code' => 200,
                    'message' => 'Bank created'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }

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

    /**
     * get User email from User key
     * 
     * @param (string) user_key
     * 
     * @return (string) email
     */
    protected function getUserEmail(string $user_key)
    {
        $user = User::where('firebase_uid', '=', $user_key)->first();
        if (!$user) {
            $user = $this->userDetail($user_key);
        }

        if (!$user) {
            $user = User::where('email', base64_decode($user_key))->first();
        }

        if (!$user) {
            return '';
        } else {
            return (string) $user->email;
        }
    }

    /**
     * get article array
     * 
     * @return (array)
     */
    private function getArticleArray(): array
    {
        return [
            'id AS article_id',
            'title AS article_title',
            'author AS article_author',
            'img AS article_image',
            'description AS article_content',
            'statistic AS article_views',
            'created_at AS article_time',
        ];
    }
}