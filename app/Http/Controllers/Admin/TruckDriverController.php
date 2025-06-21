<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScoreCard;
use App\Models\TruckDriver;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TruckDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datalist=TruckDriver::all()->where('status','=','Aktif');
       // return view('admin.truckdriver', ['datalist' => $datalist]);
        return view('admin.truckdriver', ['datalist' => $datalist]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yil = date('Y');
        $ay =date('n');


        if ($ay >= 1 && $ay <= 6) {
            $getir_maas=DB::table( 'tanimlamalars')->where('yil','=',$yil)->value('asgari_ucret');
        } else {
            $getir_maas=DB::table( 'tanimlamalars')->where('yil','=',$yil)->value('asgari_ucret2');
        }

        return view('admin.truckdriver_add', ['getir_maas' => $getir_maas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ad=strtoupper($request->input('ad'));
        $soyad=strtoupper($request->input('soyad'));
        $tc_no=$request->input('tc_no');

        $date1= new DateTime();
        $date2 =new DateTime($request->input('dogum_tarihi'));
        $date3 =new DateTime($request->input('start_date'));
        $difference = $date1->diff($date2);//yaşını
        $difference2 = $date1->diff($date3);//kaç yıl çalıştığı
        $calisma_yil=$difference2->y;
        $yas = $difference->y;

        $date4=Carbon::parse($request->input('start_date'));
        $yeniTarih = $date4->addYear();

        $date5=$yeniTarih->toDateString();

        if ($calisma_yil>=1){
            if($yas>=50){
                if ($calisma_yil<=15 ){
                    $hak_edis=20;
                }
                else{
                    $hak_edis=26;
                }
            }else{
                if($calisma_yil>=1 && $calisma_yil<6){
                    $hak_edis=14;
                }
                elseif($calisma_yil>=6 && $calisma_yil<15){
                    $hak_edis=20;
                }
                elseif($calisma_yil>=15 ){
                    $hak_edis=26;
                }
            }}else{
                $hak_edis=0;
            }

        DB::table('annual_leave_control')->insert([
            [
                'ad' =>$ad ,
                'soyad' =>$soyad,
                'tc_no'=>$tc_no,
                'start_date'=>$request->input('start_date'),
                'dogum_tarihi'=>$request->input('dogum_tarihi'),
                'gelecek_izin_tarihi'=>$date5
            ]
        ]);


        $data=new TruckDriver;
        $data->ad = $ad;
        $data->soyad = $soyad;
        $data->adres = $request->input('adres');
        $data->telefon = $request->input('telefon');
        $data->departman = $request->input('departman');
        $data->tc_no = $tc_no;
        $data->start_date = $request->input('start_date');
        $data->dogum_tarihi = $request->input('dogum_tarihi');
        $data->kan_grubu = $request->input('kan_grubu');
        $data->acil_ad_soyad = $request->input('acil_ad_soyad');
        $data->acil_telefon = $request->input('acil_telefon');
        $data->banka_adi = $request->input('banka');
        $data->banka_adi = $request->input('banka_adi');
        $data->iban = $request->input('iban');
        $data->ehliyet_tarihi = $request->input('driver_licence_end_date');
        $data->yillik_izin_hakedis = $hak_edis;
        $data->log_id =Auth::id();
        $data->maas =str_replace(',', '.', $request->input('maas'));
        $data->status = $request->input('status');
        if($request->file('image') != null) {
            $data->image = Storage::putFile('images', $request->file('image'));
        }
        $data->save();

        if($data){
            $notification=array(
                'message'=>'Şoför Eklenmiştir.',
                'alert-type'=>'success'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }
        return redirect()->route('admin_truckdriver')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function show(TruckDriver $truckDriver,$id)
    {
        $yil = date('Y');
        $ay =date('n');
        //$ay =date('n');


        if ($ay >= 1 && $ay <= 9) {
            $trh_frmt=$yil."-0".$ay."-"."%";
        } else {
            $trh_frmt=$yil."-".$ay."-"."%";
        }
        $datalist = DB::table( 'truck_drivers')->get()->where('id','=',$id);
        $getir_maas=DB::table( 'truck_drivers')->where('id','=',$id)->value('maas');
        $datalist2 = DB::table( 'score_cards')->get()->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sortBy('giris_gun');
        $datalist3 = DB::table( 'score_cards') ->select(DB::raw("DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(saat_farki))), '%H:%i') AS toplam_saat"))->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->value('toplam_saat');
        $dtlst5=DB::select("SELECT COUNT(*) AS tarih_sayisi FROM resmi_tatiller WHERE  yilbasi LIKE '$trh_frmt'  OR isci_bayrami LIKE '$trh_frmt' OR nisan23 LIKE '$trh_frmt' OR mayis19 LIKE '$trh_frmt' OR temmuz15 LIKE '$trh_frmt' OR agusto30 LIKE '$trh_frmt' OR ekim29 LIKE '$trh_frmt'");
        $dtlst6=DB::select("SELECT COUNT(*) AS tarih_sayisi2 FROM ramazan_bayrami WHERE  ramazan1 LIKE '$trh_frmt' OR ramazan2 LIKE '$trh_frmt' OR ramazan3 LIKE '$trh_frmt'");
        $dtlst7=DB::select("SELECT COUNT(*) AS tarih_sayisi3 FROM kurban_bayrami WHERE  kurban1 LIKE '$trh_frmt' OR kurban2 LIKE '$trh_frmt' OR kurban3 LIKE '$trh_frmt' OR kurban4 LIKE '$trh_frmt'");
        $dtlst8=DB::table( 'resmi_tatiller')->get()->where('yil','=',$yil);
        $dtlst9=DB::table( 'ramazan_bayrami')->get()->where('yil','=',$yil);
        $dtlst10=DB::table( 'kurban_bayrami')->get()->where('yil','=',$yil);
        $dtlst11=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sum('kazandigi_total_ucret');
        $dtlst12=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sum('sefer_sayisi');
        $dtlst13=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sum('sefer_total_ucret');


//HAFTA İÇİNİ BULDUK
        $ilkGun = mktime(0, 0, 0, $ay, 1, $yil);
        $sonGun = mktime(0, 0, 0, $ay + 1, 0, $yil);


        $haftaicisayisi=0;
        $resmitatil_sayisi=0;
        $resmitatil_sayisi_pazar=0;
        $ramazantatil_sayisi=0;
        $ramazan_sayisi_pazar=0;
        $kurbantatil_sayisi=0;
        $kurban_sayisi_pazar=0;
        $pazarsayisi=0;
        $ramazan_arefe_saat=0;
        $ramazan_arefe_dakika=0;
        $kurban_arefe_saat=0;
        $kurban_arefe_dakika=0;
        $saatlik_ucret=0;
        $aylik_total_kazanc=0;
        $fazla_ekstra_kazanc=0;
        $pazarlar = array();
        $eslesenler = array();
        $eslesenler2 = array();
        $eslesenler3 = array();

        for ($gun = $ilkGun; $gun <= $sonGun; $gun += 86400) { // Günleri birer birer kontrol et
            $haftaninGunu = date("N", $gun); // Günün haftanın kaçıncı günü olduğunu bul
            if ($haftaninGunu >= 1 && $haftaninGunu <= 5) { // Hafta içi günlerini kontrol et (Pazartesi = 1, Cuma = 5)
                $haftaicisayisi++;
            }elseif ($haftaninGunu==7){
                $gunAyYil = date("Y-m-d", $gun);
                array_push($pazarlar, $gunAyYil);
                $pazarsayisi++;

            }
        }

        if($ay==5){
            foreach ($pazarlar as $pazar) {
                foreach ($dtlst8 as $tatil) {
                    if($pazar==$tatil->isci_bayrami || $pazar == $tatil->mayis19){
                        $eslesenler[] = [
                            'pazar' => $pazar,
                        ];
                        $resmitatil_sayisi_pazar=count($eslesenler);
                    }
                }
            }

            foreach ($pazarlar as $pazar2) {
                foreach ($dtlst9 as $tatil2) {
                    if($pazar2==$tatil2->ramazan1 || $pazar2 == $tatil2->ramazan2 || $pazar2 == $tatil2->ramazan3){
                        $eslesenler2[] = [
                            'pazar' => $pazar,
                        ];
                        $ramazan_sayisi_pazar=count($eslesenler2);
                    }
                }
            }


            foreach ($pazarlar as $pazar3) {
                foreach ($dtlst10 as $tatil3) {
                    if($pazar3==$tatil3->kurban1 || $pazar3 == $tatil3->kurban2 || $pazar3 == $tatil3->kurban3 || $pazar3 == $tatil3->kurban4){
                        $eslesenler3[] = [
                            'pazar' => $pazar,
                        ];
                        $kurban_sayisi_pazar=count($eslesenler3);
                    }
                }
            }


        }elseif($ay!=5){

            foreach ($pazarlar as $pazar) {
                foreach ($dtlst8 as $tatil) {
                    if($pazar==$tatil->yilbasi || $pazar==$tatil->nisan23 || $pazar == $tatil->temmuz15 || $pazar == $tatil->agusto30 || $pazar == $tatil->ekim29){
                        $eslesenler[] = [
                            'pazar' => $pazar,
                        ];
                        $resmitatil_sayisi_pazar=count($eslesenler);
                    }
                }
            }

            foreach ($pazarlar as $pazar2) {
                foreach ($dtlst9 as $tatil2) {
                    if($pazar2==$tatil2->ramazan1 || $pazar2 == $tatil2->ramazan2 || $pazar2 == $tatil2->ramazan3){
                        $eslesenler2[] = [
                            'pazar' => $pazar,
                        ];
                        $ramazan_sayisi_pazar=count($eslesenler2);
                    }
                }
            }

            foreach ($pazarlar as $pazar3) {
                foreach ($dtlst10 as $tatil3) {
                    if($pazar3==$tatil3->kurban1 || $pazar3 == $tatil3->kurban2 || $pazar3 == $tatil3->kurban3 || $pazar3 == $tatil3->kurban4){
                        $eslesenler3[] = [
                            'pazar' => $pazar,
                        ];
                        $kurban_sayisi_pazar=count($eslesenler3);
                    }
                }
            }


        }

        //resmi tatil varsa
        if($dtlst5[0]->tarih_sayisi==1){
            if ($ay==5){
                if ($resmitatil_sayisi_pazar!=0){
                    $resmitatil_sayisi=2-$resmitatil_sayisi_pazar;
                }else{
                    $resmitatil_sayisi=2;
                }
            }else{
                $resmitatil_sayisi=1-$resmitatil_sayisi_pazar;
            }

        }else{
            $resmitatil_sayisi=0;
        }




        //ramazan bayramı varsa
        if($dtlst6[0]->tarih_sayisi2==1){
            if ($ramazan_sayisi_pazar!=0){
                $ramazantatil_sayisi=3-$ramazan_sayisi_pazar;
                $ramazan_arefe_saat=3;
                $ramazan_arefe_dakika=30;
            }else{
                $ramazantatil_sayisi=3;
                $ramazan_arefe_saat=3;
                $ramazan_arefe_dakika=30;
            }
        }else{
            $ramazantatil_sayisi=0;
            $ramazan_arefe_saat=0;
            $ramazan_arefe_dakika=0;
        }


        //kurban bayramı
        if($dtlst7[0]->tarih_sayisi3==1){
            if ($kurban_sayisi_pazar!=0){
                $kurbantatil_sayisi=4-$kurban_sayisi_pazar;
                $kurban_arefe_saat=3;
                $kurban_arefe_dakika=30;
            }else{
                $kurbantatil_sayisi=4;
                $kurban_arefe_saat=3;
                $kurban_arefe_dakika=30;
            }
        }else{
            $kurbantatil_sayisi=0;
            $kurban_arefe_saat=0;
            $kurban_arefe_dakika=0;
        }

        //$hft_ici=haftaicisayisi;
        $aylik_gun_sayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);

        $aylik_calisma_saati=($aylik_gun_sayisi-$pazarsayisi-$resmitatil_sayisi-$kurbantatil_sayisi-$ramazantatil_sayisi)*((7*60)+30);

        $arefeler_ramazan=$ramazan_arefe_saat*60+$ramazan_arefe_dakika;
        $arefeler_kurban=$kurban_arefe_saat*60+$kurban_arefe_dakika;

        $newtotalmin=$aylik_calisma_saati-$arefeler_kurban-$arefeler_ramazan;

        $aylik_saat= floor($newtotalmin / 60);
        $aylik_dakika=$newtotalmin % 60;

        $aylik_total_saat=$aylik_saat+($aylik_dakika/60);//sayıya tekrar çevirdik

       $saatlik_ucret=round($getir_maas/$aylik_total_saat,2);


        if($datalist3!=0){
        $parcalar = explode(":", $datalist3);
        $saat_parcala = (int)$parcalar[0];
        $dakika_parcala = (int)$parcalar[1];
        $calisma_saatleri =$saat_parcala + ($dakika_parcala / 60);//saati sayıya çevirdik
    }else{
            $calisma_saatleri=0;
        }


        $total_sefer_kazanc=$dtlst13;


        if ($aylik_total_saat>=$calisma_saatleri){
            $ekstra_kazanc_ekran=0;
            $aylik_total_kazanc=$dtlst11+$total_sefer_kazanc;
        }else{
            $ekstra_kazanc_ekran=$calisma_saatleri-$aylik_total_saat;
            $fazla_ekstra_kazanc=round($ekstra_kazanc_ekran*$saatlik_ucret*1.5,2);
            $aylik_total_kazanc=$dtlst11+$total_sefer_kazanc+$fazla_ekstra_kazanc;
        }




        return view('admin.truckdriver_show',['ekstra_kazanc_ekran'=>$ekstra_kazanc_ekran,'fazla_ekstra_kazanc'=>$fazla_ekstra_kazanc,'aylik_total_kazanc'=>$aylik_total_kazanc,'total_sefer_kazanc'=>$total_sefer_kazanc,'dtlst12'=>$dtlst12,'dtlst11'=>$dtlst11,'prnt_id'=>$id,'prnt_ay'=>$ay,'prnt_yil'=>$yil,'datalist2' => $datalist2,'pazarsayisi' => $pazarsayisi,'haftaicisayisi' => $haftaicisayisi,'aylik_saat' => $aylik_saat,'aylik_dakika' => $aylik_dakika,'datalist3' => $datalist3,'datalist'=>$datalist]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function edit(TruckDriver $truckDriver,$id)
    {
        $data=TruckDriver::find($id);
        return view('admin.truckdriver_edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TruckDriver $truckDriver,$id,$ad,$soyad,$tc_no)
    {
        $tarih=Carbon::now();


        DB::table('annual_leave_control')->where('ad', $ad)->where('soyad', $soyad)->where('tc_no', $tc_no)->delete();

        DB::table('annual_leaves')->insert([
            [
                'ad' => $ad,
                'soyad' => $soyad,
                'tc_no' => $tc_no,
                'yapilan_izin_gun' => 0,
                'kalan_yillik_izin_hakki' => 0,
                'aciklama' => $tarih->toDateString().' tarihinde işten aytılmıştır.',
                "created_at" => Carbon::now(), # new \Datetime()
                "updated_at" => Carbon::now(),
            ]
        ]);

        $data=TruckDriver::find($id);
        $data->isten_ayrilma_tarihi = $tarih->toDateString();
        $data->yillik_izin_hakedis =0;
        $data->start_date =null;
        $data->status = 'Pasif';
        $data->save();

        if($data){
            $notification=array(
                'message'=>'Şoför Pasif edilmiştir.',
                'alert-type'=>'info'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function destroy(TruckDriver $truckDriver, $id)
    {
        $data=TruckDriver::find($id);
        $data->delete();
        return redirect()->route('admin_truckdriver')->with('success','Şoför Silinmiştir.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shows(Request $request)
    {
        $id = $request->input('id_s');
        $yil = $request->input('pntj_yil');
        $ay = $request->input('pntj_ay');




        if (!isset($yil) && !isset($ay)) {
            $notification=array(
                'message'=>'Lütfen Puantaj Ay ve Puantaj Yılı Seçiniz.',
                'alert-type'=>'warning'
            );
            return redirect()->route('admin_truckdriver_show', ['id' => $id])->with($notification);


        } else {
        if ($ay >= 1 && $ay <= 9) {
            $trh_frmt = $yil . "-0" . $ay . "-" . "%";
        } else {
            $trh_frmt = $yil . "-" . $ay . "-" . "%";
        }
        $datalist = DB::table('truck_drivers')->get()->where('id', '=', $id);
        $sort = DB::table('score_cards')->get()->where('sub_id', '=', $id)->where('giris_yil', '=', $yil)->where('giris_ay', '=', $ay);
        $getir_maas=DB::table( 'truck_drivers')->where('id','=',$id)->value('maas');$datalist2 = $sort->sortBy('giris_gun');
        $datalist3 = DB::table('score_cards')->select(DB::raw("DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(saat_farki))), '%H:%i') AS toplam_saat"))->where('sub_id', '=', $id)->where('giris_yil', '=', $yil)->where('giris_ay', '=', $ay)->value('toplam_saat');
        $dtlst5 = DB::select("SELECT COUNT(*) AS tarih_sayisi FROM resmi_tatiller WHERE  yilbasi LIKE '$trh_frmt'  OR isci_bayrami LIKE '$trh_frmt' OR nisan23 LIKE '$trh_frmt' OR mayis19 LIKE '$trh_frmt' OR temmuz15 LIKE '$trh_frmt' OR agusto30 LIKE '$trh_frmt' OR ekim29 LIKE '$trh_frmt'");
        $dtlst6 = DB::select("SELECT COUNT(*) AS tarih_sayisi2 FROM ramazan_bayrami WHERE  ramazan1 LIKE '$trh_frmt' OR ramazan2 LIKE '$trh_frmt' OR ramazan3 LIKE '$trh_frmt'");
        $dtlst7 = DB::select("SELECT COUNT(*) AS tarih_sayisi3 FROM kurban_bayrami WHERE  kurban1 LIKE '$trh_frmt' OR kurban2 LIKE '$trh_frmt' OR kurban3 LIKE '$trh_frmt' OR kurban4 LIKE '$trh_frmt'");
        $dtlst8 = DB::table('resmi_tatiller')->get()->where('yil', '=', $yil);
        $dtlst9 = DB::table('ramazan_bayrami')->get()->where('yil', '=', $yil);
        $dtlst10 = DB::table('kurban_bayrami')->get()->where('yil', '=', $yil);
        $dtlst11 = DB::table('score_cards')->where('sub_id', '=', $id)->where('giris_yil', '=', $yil)->where('giris_ay', '=', $ay)->sum('kazandigi_total_ucret');
        $dtlst12 = DB::table('score_cards')->where('sub_id', '=', $id)->where('giris_yil', '=', $yil)->where('giris_ay', '=', $ay)->sum('sefer_sayisi');
        $dtlst13=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sum('sefer_total_ucret');


//HAFTA İÇİNİ BULDUK
        $ilkGun = mktime(0, 0, 0, $ay, 1, $yil);
        $sonGun = mktime(0, 0, 0, $ay + 1, 0, $yil);

        $haftaicisayisi = 0;
        $resmitatil_sayisi = 0;
        $resmitatil_sayisi_pazar = 0;
        $ramazantatil_sayisi = 0;
        $ramazan_sayisi_pazar = 0;
        $kurbantatil_sayisi = 0;
        $kurban_sayisi_pazar = 0;
        $pazarsayisi = 0;
        $ramazan_arefe_saat = 0;
        $ramazan_arefe_dakika = 0;
        $kurban_arefe_saat = 0;
        $kurban_arefe_dakika = 0;
        $saatlik_ucret = 0;
        $aylik_total_kazanc = 0;
        $fazla_ekstra_kazanc = 0;
        $pazarlar = array();
        $eslesenler = array();
        $eslesenler2 = array();
        $eslesenler3 = array();

        for ($gun = $ilkGun; $gun <= $sonGun; $gun += 86400) { // Günleri birer birer kontrol et
            $haftaninGunu = date("N", $gun); // Günün haftanın kaçıncı günü olduğunu bul
            if ($haftaninGunu >= 1 && $haftaninGunu <= 5) { // Hafta içi günlerini kontrol et (Pazartesi = 1, Cuma = 5)
                $haftaicisayisi++;
            } elseif ($haftaninGunu == 7) {
                $gunAyYil = date("Y-m-d", $gun);
                array_push($pazarlar, $gunAyYil);
                $pazarsayisi++;

            }
        }

        if ($ay == 5) {
            foreach ($pazarlar as $pazar) {
                foreach ($dtlst8 as $tatil) {
                    if ($pazar == $tatil->isci_bayrami || $pazar == $tatil->mayis19) {
                        $eslesenler[] = [
                            'pazar' => $pazar,
                        ];
                        $resmitatil_sayisi_pazar = count($eslesenler);
                    }
                }
            }

            foreach ($pazarlar as $pazar2) {
                foreach ($dtlst9 as $tatil2) {
                    if ($pazar2 == $tatil2->ramazan1 || $pazar2 == $tatil2->ramazan2 || $pazar2 == $tatil2->ramazan3) {
                        $eslesenler2[] = [
                            'pazar' => $pazar,
                        ];
                        $ramazan_sayisi_pazar = count($eslesenler2);
                    }
                }
            }


            foreach ($pazarlar as $pazar3) {
                foreach ($dtlst10 as $tatil3) {
                    if ($pazar3 == $tatil3->kurban1 || $pazar3 == $tatil3->kurban2 || $pazar3 == $tatil3->kurban3 || $pazar3 == $tatil3->kurban4) {
                        $eslesenler3[] = [
                            'pazar' => $pazar,
                        ];
                        $kurban_sayisi_pazar = count($eslesenler3);
                    }
                }
            }


        } elseif ($ay != 5) {

            foreach ($pazarlar as $pazar) {
                foreach ($dtlst8 as $tatil) {
                    if ($pazar == $tatil->yilbasi || $pazar == $tatil->nisan23 || $pazar == $tatil->temmuz15 || $pazar == $tatil->agusto30 || $pazar == $tatil->ekim29) {
                        $eslesenler[] = [
                            'pazar' => $pazar,
                        ];
                        $resmitatil_sayisi_pazar = count($eslesenler);
                    }
                }
            }

            foreach ($pazarlar as $pazar2) {
                foreach ($dtlst9 as $tatil2) {
                    if ($pazar2 == $tatil2->ramazan1 || $pazar2 == $tatil2->ramazan2 || $pazar2 == $tatil2->ramazan3) {
                        $eslesenler2[] = [
                            'pazar' => $pazar,
                        ];
                        $ramazan_sayisi_pazar = count($eslesenler2);
                    }
                }
            }

            foreach ($pazarlar as $pazar3) {
                foreach ($dtlst10 as $tatil3) {
                    if ($pazar3 == $tatil3->kurban1 || $pazar3 == $tatil3->kurban2 || $pazar3 == $tatil3->kurban3 || $pazar3 == $tatil3->kurban4) {
                        $eslesenler3[] = [
                            'pazar' => $pazar,
                        ];
                        $kurban_sayisi_pazar = count($eslesenler3);
                    }
                }
            }


        }

        //resmi tatil varsa
        if ($dtlst5[0]->tarih_sayisi == 1) {
            if ($ay == 5) {
                if ($resmitatil_sayisi_pazar != 0) {
                    $resmitatil_sayisi = 2 - $resmitatil_sayisi_pazar;
                } else {
                    $resmitatil_sayisi = 2;
                }
            } else {
                $resmitatil_sayisi = 1 - $resmitatil_sayisi_pazar;
            }

        } else {
            $resmitatil_sayisi = 0;
        }


        //ramazan bayramı varsa
        if ($dtlst6[0]->tarih_sayisi2 == 1) {
            if ($ramazan_sayisi_pazar != 0) {
                $ramazantatil_sayisi = 3 - $ramazan_sayisi_pazar;
                $ramazan_arefe_saat = 3;
                $ramazan_arefe_dakika = 30;
            } else {
                $ramazantatil_sayisi = 3;
                $ramazan_arefe_saat = 3;
                $ramazan_arefe_dakika = 30;
            }
        } else {
            $ramazantatil_sayisi = 0;
            $ramazan_arefe_saat = 0;
            $ramazan_arefe_dakika = 0;
        }


        //kurban bayramı
        if ($dtlst7[0]->tarih_sayisi3 == 1) {
            if ($kurban_sayisi_pazar != 0) {
                $kurbantatil_sayisi = 4 - $kurban_sayisi_pazar;
                $kurban_arefe_saat = 3;
                $kurban_arefe_dakika = 30;
            } else {
                $kurbantatil_sayisi = 4;
                $kurban_arefe_saat = 3;
                $kurban_arefe_dakika = 30;
            }
        } else {
            $kurbantatil_sayisi = 0;
            $kurban_arefe_saat = 0;
            $kurban_arefe_dakika = 0;
        }

        //$hft_ici=haftaicisayisi;
        $aylik_gun_sayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);

        $aylik_calisma_saati = ($aylik_gun_sayisi - $pazarsayisi - $resmitatil_sayisi - $kurbantatil_sayisi - $ramazantatil_sayisi) * ((7 * 60) + 30);

        $arefeler_ramazan = $ramazan_arefe_saat * 60 + $ramazan_arefe_dakika;
        $arefeler_kurban = $kurban_arefe_saat * 60 + $kurban_arefe_dakika;

        $newtotalmin = $aylik_calisma_saati - $arefeler_kurban - $arefeler_ramazan;

        $aylik_saat = floor($newtotalmin / 60);
        $aylik_dakika = $newtotalmin % 60;

        $aylik_total_saat = $aylik_saat + ($aylik_dakika / 60);//sayıya tekrar çevirdik

        $saatlik_ucret = round($getir_maas / $aylik_total_saat, 2);

        if ($datalist3 != 0) {
            $parcalar = explode(":", $datalist3);
            $saat_parcala = (int)$parcalar[0];
            $dakika_parcala = (int)$parcalar[1];
            $calisma_saatleri = $saat_parcala + ($dakika_parcala / 60);//saati sayıya çevirdik
        } else {
            $calisma_saatleri = 0;
        }


        $total_sefer_kazanc =$dtlst13;//sefer şehirleri çıktığında değişti


        if ($aylik_total_saat >= $calisma_saatleri) {
            $ekstra_kazanc_ekran = 0;
            $aylik_total_kazanc = $dtlst11 + $total_sefer_kazanc;
        } else {
            $ekstra_kazanc_ekran = $calisma_saatleri - $aylik_total_saat;
            $fazla_ekstra_kazanc = round($ekstra_kazanc_ekran * $saatlik_ucret * 1.5, 2);
            $aylik_total_kazanc = $dtlst11 + $total_sefer_kazanc + $fazla_ekstra_kazanc;
        }

        return view('admin.truckdriver_show', ['ekstra_kazanc_ekran' => $ekstra_kazanc_ekran, 'fazla_ekstra_kazanc' => $fazla_ekstra_kazanc, 'aylik_total_kazanc' => $aylik_total_kazanc, 'total_sefer_kazanc' => $total_sefer_kazanc, 'dtlst12' => $dtlst12, 'dtlst11' => $dtlst11, 'prnt_id' => $id, 'prnt_ay' => $ay, 'prnt_yil' => $yil, 'datalist2' => $datalist2, 'pazarsayisi' => $pazarsayisi, 'haftaicisayisi' => $haftaicisayisi, 'aylik_saat' => $aylik_saat, 'aylik_dakika' => $aylik_dakika, 'datalist3' => $datalist3, 'datalist' => $datalist]);
    }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function yazdir(TruckDriver $truckDriver,$prnt_id,$prnt_ay,$prnt_yil)
    {
        $id=$prnt_id;
        $yil=$prnt_yil;
       $ay= $prnt_ay;


        $datalist = DB::table( 'truck_drivers')->get()->where('id','=',$id);
        $datalist2 = DB::table( 'score_cards')->get()->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay);
        $sort=$datalist2->sortBy('giris_gun');

        if ($ay >= 1 && $ay <= 9) {
            $trh_frmt=$yil."-0".$ay."-"."%";
        } else {
            $trh_frmt=$yil."-".$ay."-"."%";
        }

        $datalist3 = DB::table( 'score_cards') ->select(DB::raw("DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(saat_farki))), '%H:%i') AS toplam_saat"))->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->value('toplam_saat');
        $datalist4 = DB::table( 'tanimlamalars')->where('yil','=',$yil)->value('sefer_harcirah');
        $getir_maas=DB::table( 'truck_drivers')->where('id','=',$id)->value('maas');
        $dtlst5=DB::select("SELECT COUNT(*) AS tarih_sayisi FROM resmi_tatiller WHERE  yilbasi LIKE '$trh_frmt'  OR isci_bayrami LIKE '$trh_frmt' OR nisan23 LIKE '$trh_frmt' OR mayis19 LIKE '$trh_frmt' OR temmuz15 LIKE '$trh_frmt' OR agusto30 LIKE '$trh_frmt' OR ekim29 LIKE '$trh_frmt'");
        $dtlst6=DB::select("SELECT COUNT(*) AS tarih_sayisi2 FROM ramazan_bayrami WHERE  ramazan1 LIKE '$trh_frmt' OR ramazan2 LIKE '$trh_frmt' OR ramazan3 LIKE '$trh_frmt'");
        $dtlst7=DB::select("SELECT COUNT(*) AS tarih_sayisi3 FROM kurban_bayrami WHERE  kurban1 LIKE '$trh_frmt' OR kurban2 LIKE '$trh_frmt' OR kurban3 LIKE '$trh_frmt' OR kurban4 LIKE '$trh_frmt'");
        $dtlst8=DB::table( 'resmi_tatiller')->get()->where('yil','=',$yil);
        $dtlst9=DB::table( 'ramazan_bayrami')->get()->where('yil','=',$yil);
        $dtlst10=DB::table( 'kurban_bayrami')->get()->where('yil','=',$yil);
        $dtlst11=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sum('kazandigi_total_ucret');
        $dtlst12=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->sum('sefer_sayisi');
        $datalist13 = DB::table( 'score_cards') ->select(DB::raw("DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(mola_saati))), '%H:%i') AS toplam_mola"))->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->value('toplam_saat');

        //YAZDIR HAFTA TATİLİ//
        $dtlst14=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->where('calisma_durumu','=','calisti')->count();
        $dtlst15=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->where('calisma_durumu','=','hafta_tatil_calisti')->count();
        $dtlst16=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->where('calisma_durumu','=','resmi_tatil')->count();
        $dtlst17=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->where('calisma_durumu','=','mazaret_izini')->count();
        $dtlst18=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->where('calisma_durumu','=','raporlu')->count();
        $dtlst19=DB::table('score_cards')->where('sub_id','=',$id)->where('giris_yil','=',$yil)->where('giris_ay','=',$ay)->where('calisma_durumu','=','yillik_izni')->count();

        //YAZDIR HAFTA TATİLİ BİTİŞ//






//HAFTA İÇİNİ BULDUK
        $ilkGun = mktime(0, 0, 0, $ay, 1, $yil);
        $sonGun = mktime(0, 0, 0, $ay + 1, 0, $yil);

        $haftaicisayisi=0;
        $resmitatil_sayisi=0;
        $resmitatil_sayisi_pazar=0;
        $ramazantatil_sayisi=0;
        $ramazan_sayisi_pazar=0;
        $kurbantatil_sayisi=0;
        $kurban_sayisi_pazar=0;
        $pazarsayisi=0;
        $ramazan_arefe_saat=0;
        $ramazan_arefe_dakika=0;
        $kurban_arefe_saat=0;
        $kurban_arefe_dakika=0;
        $saatlik_ucret=0;
        $aylik_total_kazanc=0;
        $fazla_ekstra_kazanc=0;
        $pazarlar = array();
        $eslesenler = array();
        $eslesenler2 = array();
        $eslesenler3 = array();

        for ($gun = $ilkGun; $gun <= $sonGun; $gun += 86400) { // Günleri birer birer kontrol et
            $haftaninGunu = date("N", $gun); // Günün haftanın kaçıncı günü olduğunu bul
            if ($haftaninGunu >= 1 && $haftaninGunu <= 5) { // Hafta içi günlerini kontrol et (Pazartesi = 1, Cumartesi = 6)
                $haftaicisayisi++;
            }elseif ($haftaninGunu==7){
                $gunAyYil = date("Y-m-d", $gun);
                array_push($pazarlar, $gunAyYil);
                $pazarsayisi++;

            }
        }

        if($ay==5){
            foreach ($pazarlar as $pazar) {
                foreach ($dtlst8 as $tatil) {
                    if($pazar==$tatil->isci_bayrami || $pazar == $tatil->mayis19){
                        $eslesenler[] = [
                            'pazar' => $pazar,
                        ];
                        $resmitatil_sayisi_pazar=count($eslesenler);
                    }
                }
            }

            foreach ($pazarlar as $pazar2) {
                foreach ($dtlst9 as $tatil2) {
                    if($pazar2==$tatil2->ramazan1 || $pazar2 == $tatil2->ramazan2 || $pazar2 == $tatil2->ramazan3){
                        $eslesenler2[] = [
                            'pazar' => $pazar,
                        ];
                        $ramazan_sayisi_pazar=count($eslesenler2);
                    }
                }
            }


            foreach ($pazarlar as $pazar3) {
                foreach ($dtlst10 as $tatil3) {
                    if($pazar3==$tatil3->kurban1 || $pazar3 == $tatil3->kurban2 || $pazar3 == $tatil3->kurban3 || $pazar3 == $tatil3->kurban4){
                        $eslesenler3[] = [
                            'pazar' => $pazar,
                        ];
                        $kurban_sayisi_pazar=count($eslesenler3);
                    }
                }
            }


        }elseif($ay!=5){

            foreach ($pazarlar as $pazar) {
                foreach ($dtlst8 as $tatil) {
                    if($pazar==$tatil->yilbasi || $pazar==$tatil->nisan23 || $pazar == $tatil->temmuz15 || $pazar == $tatil->agusto30 || $pazar == $tatil->ekim29){
                        $eslesenler[] = [
                            'pazar' => $pazar,
                        ];
                        $resmitatil_sayisi_pazar=count($eslesenler);
                    }
                }
            }

            foreach ($pazarlar as $pazar2) {
                foreach ($dtlst9 as $tatil2) {
                    if($pazar2==$tatil2->ramazan1 || $pazar2 == $tatil2->ramazan2 || $pazar2 == $tatil2->ramazan3){
                        $eslesenler2[] = [
                            'pazar' => $pazar,
                        ];
                        $ramazan_sayisi_pazar=count($eslesenler2);
                    }
                }
            }

            foreach ($pazarlar as $pazar3) {
                foreach ($dtlst10 as $tatil3) {
                    if($pazar3==$tatil3->kurban1 || $pazar3 == $tatil3->kurban2 || $pazar3 == $tatil3->kurban3 || $pazar3 == $tatil3->kurban4){
                        $eslesenler3[] = [
                            'pazar' => $pazar,
                        ];
                        $kurban_sayisi_pazar=count($eslesenler3);
                    }
                }
            }


        }

        //resmi tatil varsa
        if($dtlst5[0]->tarih_sayisi==1){
            if ($ay==5){
                if ($resmitatil_sayisi_pazar!=0){
                    $resmitatil_sayisi=2-$resmitatil_sayisi_pazar;
                    $yazdir_resmitatil=2;
                }else{
                    $resmitatil_sayisi=2;
                    $yazdir_resmitatil=2;
                }
            }else{
                $resmitatil_sayisi=1-$resmitatil_sayisi_pazar;
                $yazdir_resmitatil=1;
            }

        }else{
            $resmitatil_sayisi=0;
            $yazdir_resmitatil=0;
        }




        //ramazan bayramı varsa
        if($dtlst6[0]->tarih_sayisi2==1){
            if ($ramazan_sayisi_pazar!=0){
                $ramazantatil_sayisi=3-$ramazan_sayisi_pazar;
                $ramazan_arefe_saat=3;
                $ramazan_arefe_dakika=30;
                $yazdir_ramazantatil=3;
            }else{
                $ramazantatil_sayisi=3;
                $ramazan_arefe_saat=3;
                $ramazan_arefe_dakika=30;
                $yazdir_ramazantatil=3;
            }
        }else{
            $ramazantatil_sayisi=0;
            $ramazan_arefe_saat=0;
            $ramazan_arefe_dakika=0;
            $yazdir_ramazantatil=0;
        }


        //kurban bayramı
        if($dtlst7[0]->tarih_sayisi3==1){
            if ($kurban_sayisi_pazar!=0){
                $kurbantatil_sayisi=4-$kurban_sayisi_pazar;
                $kurban_arefe_saat=3;
                $kurban_arefe_dakika=30;
                $yazdir_kurbantatil=4;
            }else{
                $kurbantatil_sayisi=4;
                $kurban_arefe_saat=3;
                $kurban_arefe_dakika=30;
                $yazdir_kurbantatil=4;
            }
        }else{
            $kurbantatil_sayisi=0;
            $kurban_arefe_saat=0;
            $kurban_arefe_dakika=0;
            $yazdir_kurbantatil=0;
        }

        //$hft_ici=haftaicisayisi;
        $aylik_gun_sayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);

        $aylik_calisma_saati=($aylik_gun_sayisi-$pazarsayisi-$resmitatil_sayisi-$kurbantatil_sayisi-$ramazantatil_sayisi)*((7*60)+30);

        $yazdir_haftaici=($aylik_gun_sayisi-$pazarsayisi-$resmitatil_sayisi-$kurbantatil_sayisi-$ramazantatil_sayisi);

        $yazdir_pazar=$pazarsayisi-$resmitatil_sayisi_pazar-$kurban_sayisi_pazar-$ramazan_sayisi_pazar;

        $yazdir_ozelgunler=$yazdir_resmitatil+$yazdir_ramazantatil+$yazdir_kurbantatil;



        $arefeler_ramazan=$ramazan_arefe_saat*60+$ramazan_arefe_dakika;
        $arefeler_kurban=$kurban_arefe_saat*60+$kurban_arefe_dakika;

        $newtotalmin=$aylik_calisma_saati-$arefeler_kurban-$arefeler_ramazan;

        $aylik_saat= floor($newtotalmin / 60);
        $aylik_dakika=$newtotalmin % 60;

        $aylik_total_saat=$aylik_saat+($aylik_dakika/60);//sayıya tekrar çevirdik

        $saatlik_ucret=round($getir_maas/$aylik_total_saat,2);

        if($datalist3!=0){
            $parcalar = explode(":", $datalist3);
            $saat_parcala = (int)$parcalar[0];
            $dakika_parcala = (int)$parcalar[1];
            $calisma_saatleri =$saat_parcala + ($dakika_parcala / 60);//saati sayıya çevirdik
        }else{
            $calisma_saatleri=0;
        }


        $total_sefer_kazanc=$datalist4*$dtlst12;


        if ($aylik_total_saat>=$calisma_saatleri){
            $ekstra_kazanc_ekran=0;
            $aylik_total_kazanc=$dtlst11+$total_sefer_kazanc;
        }else{
            $ekstra_kazanc_ekran=$calisma_saatleri-$aylik_total_saat;
            $fazla_ekstra_kazanc=round($ekstra_kazanc_ekran*$saatlik_ucret*1.5,2);
            $aylik_total_kazanc=$dtlst11+$total_sefer_kazanc+$fazla_ekstra_kazanc;
        }



        return view('admin.truckdriver_yazdir', ['dtlst19' => $dtlst19,'dtlst18' => $dtlst18,'dtlst17' => $dtlst17,'dtlst16' => $dtlst16,'dtlst15' => $dtlst15,'dtlst14' => $dtlst14,'datalist13' => $datalist13,'dtlst12' => $dtlst12,'yazdir_ozelgunler' => $yazdir_ozelgunler,'yazdir_pazar' => $yazdir_pazar,'yazdir_haftaici' => $yazdir_haftaici,'ekstra_kazanc_ekran' => $ekstra_kazanc_ekran,'datalist3' => $datalist3,'aylik_dakika' => $aylik_dakika,'aylik_saat' => $aylik_saat,'datalist' => $datalist,'sort' => $sort,'prnt_ay'=>$ay,'prnt_yil'=>$yil]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function guncelle(Request $request, TruckDriver $truckDriver,$id)
    {
        $ad=strtoupper($request->input('ad'));
        $soyad=strtoupper($request->input('soyad'));


        $data=TruckDriver::find($id);
        $data->ad= $ad;
        $data->soyad= $soyad;
        $data->tc_no = $request->input('tc_no');
        $data->dogum_tarihi = $request->input('dogum_tarihi');
        $data->adres = $request->input('adres');
        $data->telefon = $request->input('telefon');
        $data->maas = str_replace(',', '.', $request->input('maas'));
        $data->start_date = $request->input('start_date');
        $data->save();





        if($data){
            $notification=array(
                'message'=>'Şoför Bilgileri Güncellenmiştir.',
                'alert-type'=>'info'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }

        return redirect()->route('admin_truckdriver')->with($notification);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function passive()
    {
        $datalist=TruckDriver::all()->where('status','=','Pasif');

        return view('admin.truckdriver_passive_list', ['datalist' => $datalist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TruckDriver  $truckDriver
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, TruckDriver $truckDriver,$id,$ad,$soyad,$tc_no,$dogum_tarihi)
    {
        $tarih=Carbon::now();
        $tarih2=Carbon::now();
        $yeniTarih = $tarih->addYear();

        $date1= new DateTime();
        $date6=new DateTime();
        $date2 =new DateTime($dogum_tarihi);
        $difference = $date1->diff($date2);//yaşını
        $difference2 = $date1->diff($date6);//kaç yıl çalıştığı
        $calisma_yil=$difference2->y;
        $yas = $difference->y;



        DB::table('annual_leave_control')->insert([
            [
                'ad' => $ad,
                'soyad' => $soyad,
                'tc_no' => $tc_no,
                'start_date' =>$tarih2->toDateString() ,
                'dogum_tarihi' => $dogum_tarihi,
                'gelecek_izin_tarihi'=>$yeniTarih->toDateString()
            ]
        ]);



        DB::table('annual_leaves')->insert([
            [
                'ad' => $ad,
                'soyad' => $soyad,
                'tc_no' => $tc_no,
                'yapilan_izin_gun' => 0,
                'kalan_yillik_izin_hakki' => 0,
                'aciklama' => $tarih->toDateString().' tarihinde işe başlamıştır.',
                "created_at" => Carbon::now(), # new \Datetime()
                "updated_at" => Carbon::now(),
            ]
        ]);



        $data=TruckDriver::find($id);
        $data->isten_ayrilma_tarihi = null;
        $data->yillik_izin_hakedis =0;
        $data->start_date =$tarih2->toDateString();
        $data->status = 'Aktif';
        $data->save();

        if($data){
            $notification=array(
                'message'=>'Şoför Aktif edilmiştir.',
                'alert-type'=>'success'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }

        return redirect()->back()->with($notification);
    }






}
