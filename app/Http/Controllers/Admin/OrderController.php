<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function table()
    {
        return DataTables::of(Order::all())
            ->addColumn('product', function ($order) {
                return $order->product()->first()->name;
            })
            ->addColumn('email', function ($order) {
                return $order->user()->first()->email;
            })
            ->addColumn('status', function ($order) {
                switch ($order->status) {
                    case 'waiting':
                        return '<span class="badge badge-warning">Waiting</span>';
                        break;
                    case 'paid':
                        return '<span class="badge badge-info">Paid</span>';
                        break;
                    case 'investing':
                        return '<span class="badge badge-primary">Investing</span>';
                        break;
                    case 'done':
                        return '<span class="badge badge-success">Done</span>';
                        break;
                    default:
                        return $order->status;
                        break;
                }
            })
            ->addColumn('action', function ($order) {
                return 'this will pop up modal';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
