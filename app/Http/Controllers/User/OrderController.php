<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Order;
use App\User;
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
          ->orderBy('orders.created_at', 'DESC')
          ->orderBy('orders.status')
          ->get();

          return DataTables::of($orders)
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
          ->orderBy('orders.created_at', 'DESC')
          ->orderBy('orders.status')
          ->get();

          return DataTables::of($orders)
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

    public function order()
    {

    }
}
