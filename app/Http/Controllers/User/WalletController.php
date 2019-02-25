<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Balance;
use App\Account;
use App\Withdraw;
use App\User;
use Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $balance = $user->balance()->first();
        $accounts = $user->accounts()->paginate(5);

        return view('user.wallet')
            ->with([
                'user' => $user,
                'accounts' => $accounts,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.account')
            ->with('banks', config('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banks = config('banks');
        $validator = Validator::make($request->all(), [
            'nama' => array('required'),
            'rekening' => array('required', Rule::in(array_keys($banks))),
            'nomor' => array('required', 'numeric', 'digits_between:10,15'),
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $account = Account::create([
            'user_id' => auth()->user()->id,
            'name' => $banks[$request->rekening],
            'holder_name' => $request->nama,
            'number' => $request->nomor,
            'account_code' => $request->rekening,
        ]);

        return redirect()
            ->route('user.wallet');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()
            ->route('user.wallet');
    }

    public function withdraw()
    {
        $user = User::find(auth()->user()->id);

        return view('user.withdraw')
            ->with([
                'user' => $user,
            ]);
    }

    public function withdrawStore(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $validator = Validator::make($request->all(), [
            'number' => array(
                'required',
                Rule::exists('accounts')->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                }),
            ),
            'amount' => array(
                'required',
                'numeric',
                'max:' . $user->balance()->first()->balance,
                'min:0'
            ),
        ],
        [
            'number.required' => 'Anda belum memilih rekening',
            'number.exists' => 'Rekening yang Anda pilih tidak sesuai',
            'amount.required' => 'Jumlah pencairan dibutuhkan',
            'amount.numeric' => 'Jumlah saldo yang dicairkan harus dalam bentuk nominal angka',
            'amount.min' => 'Minimal saldo yang dapat dicairkan adalah Rp :min',
            'amount.max' => 'Maksimal saldo yang dapat dicairkan adalah Rp :max',
        ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $account = $user->accounts()->where('number', $request->number)->first();

        Withdraw::create([
            'user_id' => $user->id,
            'account_id' => $account->id,
            'amount' => $request->amount,
        ]);

        return redirect()
            ->route('user.wallet')
            ->with([
                'status' =>'Pencairan saldo telah diproses'
            ]);
    }
}
