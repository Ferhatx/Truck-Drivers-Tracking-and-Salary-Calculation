<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

class HomeController extends Controller
{
    public function index(){
       // echo "home control";

        return view('home.index');
    }

    public function baba(){
        // echo "home control";

        return view('welcome');
    }
}
