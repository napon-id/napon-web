<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use Validator;
use App\Order;
use App\Product;
use App\UserInformation;
use App\User;
use App\Province;
use App\Cities;
use DB;
use Illuminate\Support\Carbon as IlluminateCarbon;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();

        if (!$userInformation->ktp || !$userInformation->phone || !$userInformation->address) {
            request()->session()->flash('status', 'Silahkan lengkapi data diri Anda <a href="'.route('user.edit').'">disini</a>');
        }
        return view('user.index')
            ->with([
                'user' => $user,
            ]);
    }

    public function edit()
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();

        if ($userInformation->born_date != NULL) {
            $userInformation->born_date = IlluminateCarbon::createFromFormat('Y-m-d', $userInformation->born_date);
        }

        if ($userInformation->province != NULL) {
            $cities = Province::find($userInformation->province)->cities()->get(['id', 'name']);
        } else {
            $cities = [];
        }

        return view('user.edit')
            ->with([
                'userInformation' => $userInformation,
                'provinces' => Province::query()->get(['id', 'name']),
                'cities' => $cities
            ]);
    }

    public function editContact()
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();
        if ($userInformation->province != NULL) {
            $cities = Province::find($userInformation->province)->cities()->get(['id', 'name']);
        } else {
            $cities = [];
        }

        return view('user.edit-contact')
            ->with([
                'userInformation' => $userInformation,
                'provinces' => Province::query()->get(['id', 'name']),
                'cities' => $cities
            ]);
    }

    public function editUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();

        if ($request->has('born_date')) {
            $request->merge([
                'born_date' => IlluminateCarbon::createFromFormat('d-m-Y', $request->born_date)
            ]);
        }

        $validator = Validator::make($request->all(), [
            'ktp' => 'required|numeric|digits:16|unique:user_informations,ktp,' . $userInformation->id,
            'born_date' => 'nullable',
            'gender' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userInformation->update($request->all());

        return redirect()
            ->route('user.edit', ['userInformation' => $userInformation])
            ->with([
                'status' => 'Informasi user berhasil diperbarui',
            ]);
    }

    public function editContactUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'address' => 'required',
            'born_place' => 'nullable|max:191',
            'city' => 'nullable|max:191',
            'province' => 'nullable|max:191',
            'postal_code' => 'nullable|numeric|digits:5',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userInformation->update($request->all());

        return redirect()
            ->route('user.edit.contact', ['userInformation' => $userInformation])
            ->with([
                'status' => 'Informasi user berhasil diperbarui',
            ]);
    }

    public function password()
    {
        return view('user.password');
    }

    public function passwordUpdate()
    {
        $this->passwordValidator()->validate();

        \request()->user()->update([
            'password' => bcrypt( \request('new_password') )
        ]);

        auth()->logout();

        request()->session()->flash('status', 'Kata sandi berhasil diperbarui. Silakan login kembali');

        return redirect('login');
    }

    public function product()
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();

        $orderCount = Order::where('user_id', auth()->user()->id)
            ->count();

        $status_select = config('treestatus');

        return view('user.product')
            ->with([
                'status_select' => $status_select,
                'userInformation' => $userInformation,
                'orderCount' => $orderCount,
            ]);
    }

    public function order()
    {
        $user = User::find(auth()->user()->id);
        $userInformation = $user->userInformation()->first();

        $products = Product::get();

        return view('user.order')
            ->with([
                'products' => $products,
                'userInformation' => $userInformation,
            ]);
    }

    public function activity()
    {
        $user = User::find(auth()->user()->id);
        $logs = $user->logs()
            ->where('user_id', $user->id)
            ->latest()->paginate(5);

        return view('user.activity')
            ->with([
                'logs' => $logs,
            ]);
    }

    // protected function
    protected function passwordValidator(): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make(\request()->only(['old_password', 'new_password', 'new_password_confirmation']), [
            'old_password' => [
                'required',
                function($attribute, $value, $fail) {
                    if (!Hash::check($value, \request()->user()->password)) {
                        $fail(__("Miss matched old password"));
                    }
                }
            ],
            'new_password' => 'required|confirmed'
        ]);
    }
}
