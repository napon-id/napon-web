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
     * Var $email
     */
    // protected $email;

    /**
     * store firebase token 
     * Var $token
     */
    // protected $token;
    
    public function __construct()
    {
        // $this->email = request()->user()->getEmail();
        $this->token = request()->bearerToken();
    }

    public function getFaq()
    {
        return response()->json([
            'result_code' => 4,
            'request_code' => 200,
            'data' => Faq::all(),
            'result_code' => 4,
        ]);
    }

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

    public function getUserDetail()
    {
        $email = request()->user()->getEmail();

        $user = DB::table('users')
            ->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
            ->select('users.*', 'user_informations.*')
            ->where('users.email', '=', $email)
            ->first();

        return response()->json([
            'token' => $this->token,
            'request_code' => 200,
            'data' => $user,
            'result_code' => 4,
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
