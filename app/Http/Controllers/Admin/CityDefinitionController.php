<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityDefinition;
use Illuminate\Http\Request;

class CityDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datalist=CityDefinition::all();
        return view('admin.citydefinition', ['datalist' => $datalist]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.citydefinition_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $iller = array('','Adana', 'Adıyaman', 'Afyon', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Artvin',
            'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale',
            'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
            'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir',
            'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya',
            'Manisa', 'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya',
            'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak',
            'Van', 'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak',
            'Bartın', 'Ardahan', 'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 'Düzce');

        if($request->input('cikis_iller')=='0' or $request->input('varis_iller')=='0' or $request->input('cikis_ilcesi')=='0' or $request->input('varis_ilcesi')=='0'){

            $notification=array(
                'message'=>'İl veya İlçe Seçimi Yapmayı Unuttunuz.',
                'alert-type'=>'error'
            );
            return redirect()->route('admin_citydefinition_add')->with($notification);
        }else{

        $cikis_iller=$iller[$request->input('cikis_iller')];
        $varis_iller=$iller[$request->input('varis_iller')];

        $data=new CityDefinition;
        $data->cikis_il = $cikis_iller;
        $data->cikis_ilce = $request->input('cikis_ilcesi');
        $data->varis_il = $varis_iller;
        $data->varis_ilce = $request->input('varis_ilcesi');
        $data->sefer_harcirah = $request->input('sefer_harcirah');
        $data->save();

            if($data){
                $notification=array(
                    'message'=>'Puantaj Şehri Eklenmiştir.',
                    'alert-type'=>'success'
                );
            }else{
                $notification=array(
                    'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin.',
                    'alert-type'=>'error'
                );
            }
            return redirect()->route('admin_citydefinition')->with($notification);



    }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CityDefinition  $cityDefinition
     * @return \Illuminate\Http\Response
     */
    public function show(CityDefinition $cityDefinition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CityDefinition  $cityDefinition
     * @return \Illuminate\Http\Response
     */
    public function edit(CityDefinition $cityDefinition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CityDefinition  $cityDefinition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CityDefinition $cityDefinition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CityDefinition  $cityDefinition
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityDefinition $cityDefinition,$id)
    {
        $data=CityDefinition::find($id);
        $data->delete();

        if($data){
            $notification=array(
                'message'=>'Puantaj Şehri Silinmiştir.',
                'alert-type'=>'success'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }
        return redirect()->route('admin_citydefinition')->with($notification);
    }
}
