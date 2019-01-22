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
        $faqs_about = Faq::where('category', 'about')
          ->get();
        $faqs_user = Faq::where('category', 'user')
          ->get();
        $faqs_investor = Faq::where('category', 'investor')
          ->get();
        $faqs_misc = Faq::where('category', 'misc')
          ->get();

        return view('home.faq')
          ->with([
            'faqs_about' => $faqs_about,
            'faqs_user' => $faqs_user,
            'faqs_investor' => $faqs_investor,
            'faqs_misc' => $faqs_misc
          ]);
    }

    public function service()
    {
        return view('home.service');
    }
}
