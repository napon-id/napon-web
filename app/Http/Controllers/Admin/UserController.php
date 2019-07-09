<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DataTables;
use App\Http\Controllers\Traits\UserData;

class UserController extends Controller
{
    use UserData;

    public function index()
    {
        return view('admin.user.index');
    }

    public function table()
    {
        return DataTables::of(User::where('role', 'user'))
            ->addColumn('created_at', function ($user) {
                return $user->created_at->format('d-m-Y h:i:s');
            })
            ->addColumn('detail', function ($user) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="' . route('admin.user.detail', [$user]) . '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="' . __('Detail') . '">
                            <i class="fas fa-fw fa-eye"></i>
                        </a>
                        <a class="btn" href="'.route('admin.user.order', [$user]).'" target="_blank" data-toggle="tooltip" data-placement="bottom" title="'. __('Tabungan') .'">
                            <i class="fas fa-list"></i>
                        </a>
                        <a class="btn" href="'.route('admin.user.balance', [$user]).'" target="_blank" data-toggle="tooltip" data-placement="bottom" title="'. __('Saldo') .'">
                            <i class="fas fa-money-bill"></i>
                        </a>
                    </div>
                ';
            })
            ->addColumn('verified', function ($user){
                return $user->email_verified_at ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>';
            })
            ->rawColumns(['detail', 'verified'])
            ->make(true);
    }

    public function detail(User $user)
    {
        return view('admin.user.detail')
            ->with('user', $this->getUserData($user));
    }

    public function order(User $user)
    {
        return view('admin.user.order')
            ->with('user', $user);
    }

    public function orderTable(User $user)
    {
        return DataTables::of($user->orders()->get())
            ->addColumn('date', function ($order) {
                return $order->created_at->format('d-m-Y h:i:sa');
            })
            ->addColumn('last_update', function ($order) {
                return $order->updated_at->format('d-m-Y h:i:sa');
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
            ->addColumn('product_name', function ($order) {
                return $order->product()->first()->name;
            })
            ->addColumn('location', function ($order) {
                return $order->location()->first()->address ?? '-';
            })
            ->addColumn('trees', function ($order) {
                return $order->product()->first()->tree_quantity;
            })
            ->addColumn('price', function ($order) {
                return formatCurrency($order->transaction()->first()->total);
            })
            ->addColumn('selling_price', function ($order) {
                return formatCurrency($order->selling_price);
            })
            ->addColumn('details', function ($order) {
                return '
                <button class="btn updates" data-id="'.$order->id.'" data-toggle="modal" data-target="#updatesModal">
                    <i class="fas fa-eye"></i>
                </button>';
            })
            ->rawColumns([
                'status', 'details'
            ])
            ->make(true);
    }
}
