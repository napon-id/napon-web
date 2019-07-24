<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Order;
use DataTables;
use App\Http\Controllers\Traits\UserData;
use App\Notification;

class UserController extends Controller
{
    use UserData;

    /**
     * user index
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * display datatable of user
     * 
     * @return DataTable
     */
    public function table()
    {
        return DataTables::eloquent(User::query()->where('role', 'user')->orderBy('created_at', 'desc'))
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
                        <a class="btn" href="'.route('admin.user.notification', [$user]).'" target="_blank" data-toggle="tooltip" data-placement="bottom" title="'. __('Notifikasi') .'">
                            <i class="fas fa-bell"></i>
                        </a>
                        <form action="'.route('admin.user.destroy', [$user]).'" method="post">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button class="btn" data-toggle="tooltip" data-placement="bottom" title="'.__('Hapus').'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->addColumn('verified', function ($user){
                return $user->email_verified_at ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>';
            })
            ->rawColumns(['detail', 'verified'])
            ->make(true);
    }

    /**
     * show user detail
     * 
     * @param App\User
     * 
     * @return array user
     */
    public function detail(User $user)
    {
        return view('admin.user.detail')
            ->with('user', $this->getUserData($user));
    }

    /**
     * show user orders data
     * 
     * @param App\User
     * 
     * @return App\User
     */
    public function order(User $user)
    {
        return view('admin.user.order')
            ->with('user', $user);
    }

    /**
     * display datatable of user order
     * 
     * @param App\User
     * 
     * @return DataTable
     */
    public function orderTable(User $user)
    {
        return DataTables::eloquent(Order::query()->where('user_id', $user->id)->orderBy('created_at', 'desc'))
            ->addColumn('details', function ($order) {
                return '
                <button class="btn updates" data-id="'.$order->id.'" data-toggle="modal" data-target="#updatesModal">
                    <i class="fas fa-eye"></i>
                </button>';
            })
            ->addColumn('product_name', function ($order) {
                return $order->product->name;
            })
            ->addColumn('location', function ($order) {
                return $order->location->location ?? '-';
            })
            ->addColumn('transaction', function ($order) {
                return $order->transaction['queue'];
            })
            ->editColumn('buy_price', function ($order) {
                return formatCurrency($order->buy_price, 'IDR');
            })
            ->editColumn('selling_price', function ($order) {
                return formatCurrency($order->selling_price, 'IDR');
            })
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('d-m-Y h:i:s');
            })
            ->editColumn('updated_at', function ($order) {
                return $order->updated_at->format('d-m-Y h:i:s');
            })
            ->editColumn('status', function ($order) {
                switch ($order->status) {
                    case 1:
                        return 'Menunggu pembayaran';
                        break;
                    case 2: 
                        return 'Tidak dibayar';
                        break;
                    case 3:
                        return 'Berjalan';
                        break;
                    case 4:
                        return 'Selesai';
                        break;
                    default:
                        return 'undefined';
                        break;
                }
            })
            ->editColumn('img_certificate', function ($order) {
                return isset($order->img_certificate) ? 
                    '
                    <img src="'.$order->img_certificate.'" class="img-fluid img-thumbnail">
                    ' : '-';
            }) 
            ->addColumn('details', function ($order) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.user.order.edit', [$order->user, $order]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a class="btn" href="'.route('admin.user.order.report', [$order->user()->first(), $order]).'" data-toggle="tooltip" data-placement="bottom" title="'. __('Laporan') .'">
                            <i class="fas fa-list"></i>
                        </a>
                        <a class="btn" href="'.route('admin.user.order.location', [$order->user, $order]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Lokasi').'">
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                    </div>
                ';
            })
            ->rawColumns([
                'status', 'img_certificate', 'details'
            ])
            ->make(true);
    }

    /**
     * show user notifications data
     * 
     * @param App\User
     * 
     * @return Illuminate\View\View
     */
    public function notification(User $user)
    {
        return view('admin.user.notification')
            ->with('user', $user);
    }

    /**
     * get datatable of notifications
     * 
     * @param App\User
     * 
     * @return DataTable
     */
    public function notificationTable(User $user)
    {
        return DataTables::eloquent(Notification::query()->where('user_id', '=', $user->id)->orderBy('created_at', 'desc'))
            ->editColumn('status', function ($notification) {
                return $notification->status == 1 ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>';
            })
            ->editColumn('created_at', function ($notification) {
                return $notification->created_at->format('d-m-Y h:i:s');
            })
            ->addColumn('action', function ($notification) {
                return '
                    <div class="btn-group">
                        <form action="'.route('admin.user.notification.destroy', [$notification->user()->first(), $notification]).'" method="post">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button class="btn" data-toggle="tooltip" data-placement="bottom" title="'.__('Hapus').'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * destroy selected user
     * 
     * @param App\User
     * 
     * @return Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.user')
            ->with('status', __('User dihapus'));
    }
}
