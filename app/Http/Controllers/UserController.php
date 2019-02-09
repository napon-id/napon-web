<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Order;
use App\Product;
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
        $status_select = [
          'waiting' => 'Menunggu top-up pembayaran',
          'paid' => 'Pohon sedang ditanam',
          'investing' => 'Pohon telah ditanam',
          'done' => 'Produk tabungan telah selesai',
        ];

        return view('user.product')
          ->with([
            'status_select' => $status_select,
          ]);
    }

    public function order()
    {
        $products = Product::get();

        return view('user.order')
          ->with([
            'products' => $products,
          ]);
    }
}
