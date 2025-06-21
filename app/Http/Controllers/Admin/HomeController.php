<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $datalist = DB::table( 'truck_drivers')->where('status','=','Aktif')->count();
        return view('admin.index',['datalist' => $datalist]);
    }

    public function login(){
        return view('admin.login');
    }

    public function logincheck(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('admin');
            }

            return back()->withErrors([
                'email' => 'Kimlik Bilgileriniz Yanlıştır.',]);

        }else{
            return  view('home.index');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification=array(
            'message'=>'Çıkış Yapılmıştır.',
            'alert-type'=>'success'
        );

        return redirect()->route('admin_login')->with($notification);
    }


}
