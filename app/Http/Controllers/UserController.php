<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }

    public function index()
    {
        return view('user.index');
    }

    public function product()
    {
        $user_id = auth()->user()->id;

        $orders = DB::table('orders')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->join('trees', 'products.tree_id', '=', 'trees.id')
          ->select('orders.*', 'products.name as product_name', 'tree_quantity as product_tree_quantity', 'products.percentage as product_percentage', 'trees.price as tree_price')
          ->where('orders.user_id', '=', $user_id)
          ->orderBy('orders.created_at', 'DESC')
          ->get();

        return view('user.product')
          ->with([
            'orders' => $orders
          ]);
    }

    public function order()
    {
        return view('user.order');
    }
}
