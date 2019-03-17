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
        return DataTables::eloquent(Order::query()->orderBy('created_at', 'desc'))
            ->addColumn('date', function ($order) {
                return $order->created_at;
            })
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
                return '
                    <div class="btn-group">
                        <button class="btn order-update-modal" data-toggle="modal" data-target="#orderUpdateModal" data-url="'.route('admin.order.edit', [$order->id]).'" data-post="'.route('admin.order.update', [$order->id]).'">
                        <i class="fas fa-pencil-alt"></i>
                        </button>
                        <a href="'.route('admin.order.update.index', [$order]).'" class="btn" data-toggle="tooltip" data-placement="bottom" title="order updates" target="_blank">
                            <i class="fas fa-list-ol"></i>
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function edit($id)
    {
        return response()->json(Order::find($id));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        // if ($request->selling_price) {
        //     $order->selling_price = $request->selling_price;
        // }
        if ($request->status) {
            $order->status = $request->status;
        }
        $order->save();

        return response()->json([
            'order' => $order,
        ]);
    }
}
