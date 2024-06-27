<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user =  Auth::user();
        return view('index' , compact('user'));
    }

    public function store()
    {
        redirect ('/' , compact('user'));
    }

}
