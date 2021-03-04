<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public Function semPermissao()
    {
        return view('admin.error.permissao');
    }
}
