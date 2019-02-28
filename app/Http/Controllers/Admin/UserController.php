<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function table()
    {
        return DataTables::of(User::where('role', 'user'))
            ->addColumn('created_at', function ($user) {
                return $user->created_at->format('d-m-Y h:i:sa');
            })
            ->addColumn('detail', function ($user) {
                return '
                    <button class="btn detail" data-id="'.$user->id.'">
                        <span class="fas fa-fw fa-eye" data-toggle="modal" data-target="#userDetail"></span>
                    </button>
                ';
            })
            ->addColumn('verified', function ($user){
                return $user->email_verified_at;
            })
            ->rawColumns(['detail'])
            ->make(true);
    }

    public function detail()
    {
        $id = request()->get('id');
        return User::findOrFail($id)->userInformation()->first();
    }
}
