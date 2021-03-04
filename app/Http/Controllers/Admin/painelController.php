<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class painelController extends Controller
{
    public function index(){   
        return view('painel.dashboard.index');
    }

    public function authenticateUsr(){
        return auth()->user()->nivel;
    }
}
