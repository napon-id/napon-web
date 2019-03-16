<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdraw;
use App\User;
use DataTables;

class BalanceController extends Controller
{
    public function index(User $user)
    {
        return view('admin.user.balance')
            ->with('user', $user);
    }

    public function table(User $user)
    {
        return DataTables::of($user->withdraws()->get())
            ->addColumn('date', function ($withdraw) {
                return $withdraw->created_at->format('d-m-Y h:i:sa');
            })
            ->addColumn('amount', function ($withdraw) {
                return formatCurrency($withdraw->amount);
            })
            ->addColumn('status', function ($withdraw) {
                switch ($withdraw->status) {
                    case 'waiting':
                        return '<span class="badge badge-warning">Waiting</span>';
                        break;
                    case 'approved':
                        return '<span class="badge badge-info">Approved</span>';
                        break;
                    case 'rejected':
                        return '<span class="badge badge-danger">Rejected</span>';
                        break;
                    case 'done':
                        return '<span class="badge badge-success">Done</span>';
                        break;
                    default:
                        return '<span class="badge badge-primary">Status undefined</span>';
                        break;
                }
            })
            ->rawColumns(['status'])
            ->make(true);
    }
}
