<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tree;
use App\Product;
use App\User;
use App\Order;
use DB;
use App\Faq;

class ApiController extends Controller
{
    public function getFaq()
    {
        return response()->json([
            'result_code' => 200,
            'data' => Faq::all(),
        ]);
    }

    public function getUser()
    {
        $user = User::where('role', 'user')->get();

        return response()->json([
            'result_code' => 200,
            'data' => $user,
        ]);
    }

    public function getUserDetail(User $user)
    {
        $user = DB::table('users')
            ->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
            ->select('users.*', 'user_informations.*')
            ->where('users.id', '=', $user->id)
            ->first();

        return response()->json([
            'result_code' => 200,
            'data' => $user,
        ]);
    }

    public function getUserOrder(User $user)
    {
        return response()->json([
            'result_code' => 200,
            'data' => $user->orders()->get(),
        ]);
    }

    public function getUserWithdraw(User $user)
    {
        return response()->json([
            'result_code' => 200,
            'data' => $user->withdraws()->get(),
        ]);
    }

    public function getUserBalance(User $user)
    {
        return response()->json([
            'result_code' => 200,
            'data' => $user->balance()->first(),
        ]);
    }

    public function getUserLog(User $user)
    {
        return response()->json([
            'result_code' => 200,
            'data' => $user->logs()->get(),
        ]);
    }

    public function getTree()
    {
        return response()->json([
            'result_code' => 200,
            'data' => Tree::all(),
        ]);
    }

    public function getProduct()
    {
        return response()->json([
            'result_code' => 200,
            'data' => Product::all(),
        ]);
    }

    public function getOrder(Order $order)
    {
        return response()->json([
            'result_code' => 200,
            'data' => $order,
        ]);
    }

    public function getOrderUpdate(Order $order)
    {
        return response()->json([
            'result_code' => 200,
            'data' => $order->updates()->get(),
        ]);
    }
}
