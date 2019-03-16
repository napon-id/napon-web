<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class AdminController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.index');
    }

    public function invest()
    {
        return view('admin.invest');
    }

    public function transaction()
    {
        return view('admin.transaction')
            ->with('transactions', Transaction::where('status', 'waiting')->latest()->get());
    }
}
