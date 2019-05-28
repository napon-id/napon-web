<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\Firebase;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use Firebase, RegistersUsers;

}