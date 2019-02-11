<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Order;
use App\User;
use App\Product;
use Validator;
use DB;

class OrderController extends Controller
{
    public function productApi()
    {
        $user_id = auth()->user()->id;

        $orders = DB::table('orders')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->join('trees', 'products.tree_id', '=', 'trees.id')
          ->select('orders.*', 'products.name as product_name', 'tree_quantity as product_tree_quantity', 'products.percentage as product_percentage', 'trees.price as tree_price')
          ->where('orders.user_id', '=', $user_id)
          ->get();

          return DataTables::of($orders)
            ->addColumn('price', function ($orders) {
              $price = $orders->tree_price * $orders->product_tree_quantity;
              return "Rp " . number_format($price, 2, ',', '.');
            })
            ->addColumn('selling_price', function ($orders) {
              if ($orders->selling_price < 1) {
                return 'Produk tabungan belum selesai';
              } else {
                return 'Rp ' . number_format($orders->selling_price, 2, ',', '.');
              }
            })
            ->addColumn('status', function ($orders) {
              if ($orders->status == 'waiting') {
                return "<p class='badge badge-dark'>Menunggu top-up pembayaran</p>";
              } else if ($orders->status == 'paid') {
                return "<p class='badge badge-warning'>Pohon sedang ditanam</p>";
              } else if ($orders->status == 'investing') {
                return "<p class='badge badge-info'>Pohon telah ditanam</p>";
              } else if ($orders->status == 'done') {
                "<p class='badge badge-success'>Produk tabungan telah selesai</p>";
              }
            })
            ->addColumn('action', function ($orders) {
              if ($orders->status == 'done') {
                return "<a class='btn btn-info' href='#!'>Lihat Detail</a>";
              } else {
                return "<a class='btn btn-info' href='#!'><i class='fas fa-eye'></i> Lihat Detail</a>";
              }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function productApiStatus($status)
    {
        $user_id = auth()->user()->id;

        $orders = DB::table('orders')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->join('trees', 'products.tree_id', '=', 'trees.id')
          ->select('orders.*', 'products.name as product_name', 'tree_quantity as product_tree_quantity', 'products.percentage as product_percentage', 'trees.price as tree_price')
          ->where('orders.user_id', '=', $user_id)
          ->where('status', $status)
          ->orderBy('orders.created_at', 'ASC')
          ->get();

          return DataTables::of($orders)
            ->addColumn('price', function ($orders) {
              $price = $orders->tree_price * $orders->product_tree_quantity;
              return "Rp " . number_format($price, 2, ',', '.');
            })
            ->addColumn('selling_price', function ($orders) {
              if ($orders->selling_price < 1) {
                return 'Produk tabungan belum selesai';
              } else {
                return 'Rp ' . number_format($orders->selling_price, 2, ',', '.');
              }
            })
            ->addColumn('status', function ($orders) {
              if ($orders->status == 'waiting') {
                return "<p class='badge badge-dark'>Menunggu top-up pembayaran</p>";
              } else if ($orders->status == 'paid') {
                return "<p class='badge badge-warning'>Pohon sedang ditanam</p>";
              } else if ($orders->status == 'investing') {
                return "<p class='badge badge-info'>Pohon telah ditanam</p>";
              } else if ($orders->status == 'done') {
                "<p class='badge badge-success'>Produk tabungan telah selesai</p>";
              }
            })
            ->addColumn('action', function ($orders) {
              if ($orders->status == 'done') {
                return "<a class='btn btn-info' href='#!'>Lihat Detail</a>";
              } else {
                return "<a class='btn btn-info' href='#!'><i class='fas fa-eye'></i> Lihat Detail</a>";
              }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function productApiOrder()
    {
        if (request()->query('id')) {
          $product = DB::table('products')
            ->join('trees', 'products.tree_id', '=', 'trees.id')
            ->select('products.*', 'trees.name as tree_name', 'trees.price as tree_price')
            ->where('products.id', request()->query('id'))
            ->first();
          // $product = Product::find(request()->query('id'));
        } else {
          $product = Product::get();
        }

        return response()->json([
          'data' => $product,
        ]);
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'product' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
          return redirect()->route('user.product.order')
            ->withErrors($validator)
            ->withInput();
        }

        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->product_id = $request->product;
        $order->save();

        return redirect()->action(
          'User\OrderController@checkout', ['id' => $order->id]
        );
    }

    public function checkout($id)
    {
        // $order = DB::table('orders')
        //   ->join('products', 'orders.product_id', '=', 'products.id')
        //   ->join('trees', 'products.tree_id', '=', 'trees.id')
        //   ->select('orders.*', 'products.tree_quantity as product_tree_quantity', 'trees.price as tree_price')
        //   ->where('orders.id', $id)
        //   ->first();
        $order = Order::findOrFail($id);
        $transaction = $order->transaction()->first();

        if ($order == null || $order->status != 'waiting' || $order->user_id != auth()->user()->id) {
          return redirect()->action(
            'UserController@product'
          );
        }

        request()->session()->flash('status', 'Proses checkout berhasil');
        return view('user.checkout')
          ->with([
            'order' => $order,
            'transaction' => $transaction,
          ]);
    }
}
