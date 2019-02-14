<?php

namespace App\Http\Controllers\Traits;

use DB;
use DataTables;

trait OrderDataTable
{
    function generateOrderDatatable($orders, $status)
    {
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
                    return "<a class='btn btn-success' href='". route('user.product.detail', ['token' => $orders->token]) ."'>Lihat Detail</a>";
                } else if ($orders->status == 'waiting') {
                    return "<a class='btn btn-warning' href='". route('user.product.checkout', ['token' => $orders->token]) ."'><i class='fas fa-eye'></i> Lihat tagihan</a>";
                } else {
                    return "<a class='btn btn-info' href='". route('user.product.detail', ['token' => $orders->token]) ."'>Pantau Tabungan</a>";
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
