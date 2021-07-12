<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class hello extends Controller
{
    public function index() {
        $name = "일지매";
        $age = 15;
        return view('show',compact('name','age'));
    }
    //
}
