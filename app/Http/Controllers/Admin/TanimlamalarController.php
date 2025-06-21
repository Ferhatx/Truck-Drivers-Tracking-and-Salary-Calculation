<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tanimlamalar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanimlamalarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datalist=DB::select("SELECT tanimlamalars.yil, tanimlamalars.asgari_ucret, tanimlamalars.asgari_ucret2,kurban_bayrami.kurban1, kurban_bayrami.kurban2, kurban_bayrami.kurban3, kurban_bayrami.kurban4, ramazan_bayrami.ramazan1, ramazan_bayrami.ramazan2, ramazan_bayrami.ramazan3, resmi_tatiller.yilbasi, resmi_tatiller.nisan23, resmi_tatiller.isci_bayrami, resmi_tatiller.mayis19, resmi_tatiller.temmuz15, resmi_tatiller.agusto30, resmi_tatiller.ekim29 FROM tanimlamalars INNER JOIN ramazan_bayrami ON ramazan_bayrami.yil=tanimlamalars.yil INNER JOIN kurban_bayrami ON kurban_bayrami.yil=tanimlamalars.yil INNER JOIN resmi_tatiller ON resmi_tatiller.yil=tanimlamalars.yil");
        return view('admin.tanimlamalar', ['datalist' => $datalist]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tanimlamalar_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yil= $request->input('yil');
        $yilbasi=$yil."-01-01";
        $nisan23=$yil."-04-23";
        $isci_bayrami=$yil."-05-01";
        $mayis19=$yil."-05-19";
        $temmuz15=$yil."-07-15";
        $agusto30=$yil."-08-30";
        $ekim29=$yil."-10-29";





        $data=new Tanimlamalar();
        $data->yil = $yil;
        $data->asgari_ucret = $request->input('asgari_ucret');
        $data->asgari_ucret2 = $request->input('asgari_ucret2');
        $data->save();

        DB::table('resmi_tatiller')->insert([
            [   'yil' =>$yil ,
                'yilbasi' => $yilbasi,
                'isci_bayrami' => $isci_bayrami,
                'nisan23' => $nisan23,
                'mayis19' => $mayis19,
                'temmuz15' => $temmuz15,
                'agusto30' => $agusto30,
                'ekim29' => $ekim29
            ]

        ]);


        DB::table('kurban_bayrami')->insert([
            [   'yil' =>$yil ,
                'kurban1' => $request->input('kurban1'),
                'kurban2' => $request->input('kurban2'),
                'kurban3' => $request->input('kurban3'),
                'kurban4' => $request->input('kurban4')
            ]

        ]);

        DB::table('ramazan_bayrami')->insert([
            [   'yil' =>$yil ,
                'ramazan1' => $request->input('ramazan1'),
                'ramazan2' => $request->input('ramazan1'),
                'ramazan3' => $request->input('ramazan1')
            ]

        ]);

        if($data){
            $notification=array(
                'message'=>'Tanımlamanız Eklenmiştir.',
                'alert-type'=>'info'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }



        return redirect()->route('admin_tanimlamalar')->with($notification);









    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tanimlamalar  $tanimlamalar
     * @return \Illuminate\Http\Response
     */
    public function show(Tanimlamalar $tanimlamalar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tanimlamalar  $tanimlamalar
     * @return \Illuminate\Http\Response
     */
    public function edit(Tanimlamalar $tanimlamalar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tanimlamalar  $tanimlamalar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tanimlamalar $tanimlamalar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tanimlamalar  $tanimlamalar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tanimlamalar $tanimlamalar, $yil)
    {

        DB::table('tanimlamalars')->where('yil', '=', $yil)->delete();
        DB::table('resmi_tatiller')->where('yil', '=', $yil)->delete();
        DB::table('ramazan_bayrami')->where('yil', '=', $yil)->delete();
        DB::table('kurban_bayrami')->where('yil', '=', $yil)->delete();



        return redirect()->route('admin_tanimlamalar')->with('success','Tanımlama Silinmiştir.');
    }
}
