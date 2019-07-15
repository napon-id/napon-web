<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.index');
    }

    public function about()
    {
        return view('home.about');
    }

    public function faq()
    {
        $faqs = Faq::get();

        return view('home.faq')
          ->with([
            'faqs' => $faqs
          ]);
    }

    public function service()
    {
        $tree = \App\Tree::find(1);
        $products = $tree->products()->get();
        return view('home.service')
          ->with([
            'products' => $products,
            'tree' => $tree,
          ]);
    }
}
