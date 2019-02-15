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
                'balance' => $balance,
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
            'nomor' => array('required', 'numeric'),
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
        abort(403, 'Fitur withdraw dapat digunakan setelah tabungan selesai berjalan');
    }
}
