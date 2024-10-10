<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        // buat manager
        return view('manager.dashboard');
    }
}
