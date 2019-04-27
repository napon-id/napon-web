<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tree;
use App\Product;
use App\User;
use App\Order;
use DB;
use App\Faq;
use App\Province;
use App\Cities;
use App\Http\Controllers\Traits\Firebase;

class ApiController extends Controller
{
    use Firebase;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        // $this->email = request()->user()->getEmail();
        $this->token = request()->bearerToken();
    }

    /**
     * return Faq
     * @return Illuminate\Http\Response
     */
    public function getFaq()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'data' => Faq::query()->get(['question AS faq_question', 'answer AS faq_answer']),
            'result_code' => 4,
        ]);
    }

    /**
     * get User list
     * @return Illuminate\Http\Response
     */
    public function getUser()
    {
        $user = User::where('role', 'user')->get();

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'data' => $user,
            'result_code' => 4,
        ]);
    }

    /**
     * get user detail based on email
     * @return Illuminate\Http\Response
     */
    public function getUserDetail()
    {
        // $email = request()->user()->getEmail();
        $email = 'akunbaru@mailinator.com';

        $user = DB::table('users')
            ->leftJoin( 'user_informations', 'users.id', '=', 'user_informations.user_id')
            ->join('cities', 'cities.id', '=', 'user_informations.city')
            ->join('provinces', 'provinces.id', '=', 'cities.province_id')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('trees', 'trees.id', '=', 'products.tree_id')
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

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'data' => $user,
            'result_code' => 4,
        ]);
    }

    public function getUserBank()
    {
        // $email = request()->user()->getEmail();
        $email = 'akunbaru@mailinator.com';

        $banks = DB::table( 'users')
            ->rightJoin('accounts', 'accounts.user_id', '=', 'users.id')
            ->select(
                DB::raw( 'accounts.name AS user_bank_name'),
                DB::raw( 'accounts.number AS user_bank_account_number'),
                DB::raw( 'accounts.account_code AS user_bank_account_code'),
                DB::raw('accounts.number AS user_bank_account_name')
            )
            ->get();
        
        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'data' => $banks,
            'result_code' => 4
        ]);
    }

    public function getUserOrder()
    {
        $email = request()->user()->getEmail();
        $user = User::where('email', '=', $email)->first();

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => $user->orders()->get(),
        ]);
    }

    public function getUserWithdraw()
    {
        $email = request()->user()->getEmail();
        $user = User::where('email', '=', $email)->first();

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => $user->withdraws()->get(),
        ]);
    }

    public function getUserBalance()
    {
        $email = request()->user()->getEmail();
        $user = User::where('email', '=', $email)->first();

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => $user->balance()->first(),
        ]);
    }

    public function getUserLog()
    {
        $email = request()->user()->getEmail();
        $user = User::where('email', '=', $email)->first();

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => $user->logs()->get(),
        ]);
    }

    public function getTree()
    {
        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => Tree::all(),
        ]);
    }

    public function getProduct()
    {
        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => Product::all(),
        ]);
    }

    public function getOrder(Order $order)
    {
        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'result_code' => 4,
            'data' => $order,
        ]);
    }

    public function getOrderUpdate(Order $order)
    {
        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'data' => $order->updates()->get(),
            'result_code' => 4,
        ]);
    }

    public function getProvinces()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'data' => Province::all(),
        ]);
    }

    public function getProvinceDetail(Province $province)
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'data' => $province,
        ]);
    }

    public function getCities(Province $province)
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'data' => $province->cities()->get(),
        ]);
    }

    public function getCityDetail(Cities $city)
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'data' => $city,
        ]);
    }
}
