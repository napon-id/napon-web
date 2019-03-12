<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdraw;
use DataTables;
use DB;

class WithdrawController extends Controller
{
    public function index()
    {
        return view('admin.withdraw.index');
    }

    public function table()
    {
        return DataTables::of(Withdraw::all())
            ->addColumn('date', function ($withdraw) {
                return $withdraw->created_at->format('d-m-Y h:i:sa');
            })
            ->addColumn('email', function ($withdraw) {
                return $withdraw->user()->first()->email;
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
            ->addColumn('action', function ($withdraw) {
                switch ($withdraw->status) {
                    case 'waiting':
                        return '
                            <button class="btn btn-sm btn-info withdraw-status" onclick="withdrawStatus(&#39;'.$withdraw->id.'&#39;, &#39;'.route('admin.withdraw.change_status').'&#39;, &#39;approved&#39;)" title="Approve">
                                <i class="fas fa-check"></i>
                            </button>

                            <button class="btn btn-sm btn-danger withdraw-status" onclick="withdrawStatus(&#39;'.$withdraw->id.'&#39;, &#39;'.route('admin.withdraw.change_status').'&#39;, &#39;rejected&#39;)" title="Reject">
                                <i class="fas fa-times"></i>
                            </button>

                        ';
                        break;
                    case 'approved':
                        return '
                            <button class="btn btn-sm btn-success withdraw-status" onclick="withdrawStatus(&#39;'.$withdraw->id.'&#39;, &#39;'.route('admin.withdraw.change_status').'&#39;, &#39;done&#39;)" title="Done">
                                <i class="fas fa-check"></i>
                            </button>
                        ';
                        break;
                    case 'rejected':
                        return '-';
                        break;
                    case 'done':
                        return '-';
                        break;
                    default:
                        return 'undefined';
                        break;
                }
            })
            ->rawColumns([
                'status',
                'action',
            ])
            ->make(true);
    }

    public function changeStatus()
    {
        if (!request()->has('id') && !request()->has('next')) {
            return response()->json([
                'status' => 'no ID and or next status for withdraw',
            ]);
        }

        DB::beginTransaction();
        try {
            $id = request()->get('id');
            $next = request()->get('next');
            $withdraw = Withdraw::find($id);

            $withdraw->update([
                'status' => $next,
            ]);
            DB::commit();

            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => $e,
            ]);
        }

    }
}
