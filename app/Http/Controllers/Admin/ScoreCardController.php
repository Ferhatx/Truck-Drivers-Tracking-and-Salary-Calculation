<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityDefinition;
use App\Models\ScoreCard;
use App\Models\TruckDriver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.scorecard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datalist=TruckDriver::all();
        $datalist2=CityDefinition::all();
        return view('admin.scorecard_add', ['datalist' => $datalist,'datalist2' => $datalist2]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bol  = $request->input('adsoyad');
        $dilimler = explode(" ", $bol);

        $ad=$dilimler[0];
        $soyad=$dilimler[1];
        $sub_id=$dilimler[2];
        $tc_no=$dilimler[3];

        $bol2  = $request->input('sfrhrch');
        $dilimler2 = explode(" ", $bol2);

        $sefer_harcirah_ucreti=$dilimler2[0];



        if (isset($dilimler2[1]) && isset($dilimler2[2]) && isset($dilimler2[3]) && isset($dilimler2[4])){
            $cikis_il=$dilimler2[1];
            $cikis_ilce=$dilimler2[2];
            $varis_il=$dilimler2[3];
            $varis_ilce=$dilimler2[4];
        $sefer_yeri=$cikis_il.' '.$cikis_ilce.' - '.$varis_il.' '.$varis_ilce;
         }







       $calisma_durum= $request->input('calisma_durum');

        $aciklama= $request->input('aciklama');

        $mola_saat= $request->input('molaSaat');


       $yil= $request->input('giris_yil');
       $ay= $request->input('giris_ay');
       $giris_gun= $request->input('giris_gun');
       $giris_saat= $request->input('giris_saat');

        $cikis_yil= $request->input('cikis_yil');
        $cikis_ay= $request->input('cikis_ay');
        $cikis_gun= $request->input('cikis_gun');
        $cikis_saat= $request->input('cikis_saat');

        $saat_farki= $request->input ('saat_frk');

        $tatil_calis=$request->input ('tatil_calis');
        $sefer_sayisi=str_replace(',', '.', $request->input('sefer_sayisi'));



        if ($ay >= 1 && $ay <= 9) {
            $trh_frmt=$yil."-0".$ay."-"."%";
        } else {
            $trh_frmt=$yil."-".$ay."-"."%";
        }
        $datalist = DB::table( 'truck_drivers')->where('id','=',$sub_id)->value('maas');
        $datalist11= DB::table( 'truck_drivers')->where('id','=',$sub_id)->value('yillik_izin_hakedis');

        $dtlst5=DB::select("SELECT COUNT(*) AS tarih_sayisi FROM resmi_tatiller WHERE  yilbasi LIKE '$trh_frmt'  OR isci_bayrami LIKE '$trh_frmt' OR nisan23 LIKE '$trh_frmt' OR mayis19 LIKE '$trh_frmt' OR temmuz15 LIKE '$trh_frmt' OR agusto30 LIKE '$trh_frmt' OR ekim29 LIKE '$trh_frmt'");
        $dtlst6=DB::select("SELECT COUNT(*) AS tarih_sayisi2 FROM ramazan_bayrami WHERE  ramazan1 LIKE '$trh_frmt' OR ramazan2 LIKE '$trh_frmt' OR ramazan3 LIKE '$trh_frmt'");
        $dtlst7=DB::select("SELECT COUNT(*) AS tarih_sayisi3 FROM kurban_bayrami WHERE  kurban1 LIKE '$trh_frmt' OR kurban2 LIKE '$trh_frmt' OR kurban3 LIKE '$trh_frmt' OR kurban4 LIKE '$trh_frmt'");
        $dtlst8=DB::table( 'resmi_tatiller')->get()->where('yil','=',$yil);
        $dtlst9=DB::table( 'ramazan_bayrami')->get()->where('yil','=',$yil);
        $dtlst10=DB::table( 'kurban_bayrami')->get()->where('yil','=',$yil);


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

        $aylik_total_saat=$aylik_saat+($aylik_dakika/60);




       $saatlik_ucret=round($datalist/$aylik_total_saat,2);


        $parcalar = explode(":", $saat_farki);
        $saat_parcala = (int)$parcalar[0];
        $dakika_parcala = (int)$parcalar[1];
        $calisma_saatleri =round( $saat_parcala + ($dakika_parcala / 60),2);

      //  $total_kazanc=round($calisma_saatleri*$saatlik_ucret,2);

        //izin gününde çalıştığı saat*(17000/195)* 1,5

        if($calisma_durum=='hafta_tatil'&& !isset($tatil_calis)){
            $cikis_yil="Hafta Tatili";
            $cikis_ay="Hafta Tatili";
            $cikis_gun="Hafta Tatili";
            $saat_farki="00:00";
            $total_kazanc=0;
            $mola_saat="00:00";

        }
        elseif ($calisma_durum=='hafta_tatil'&& isset($tatil_calis)){
            $total_kazanc=round($calisma_saatleri*$saatlik_ucret,2)*1.5;
            $calisma_durum='hafta_tatil_calisti';
        }
        elseif ($calisma_durum=='calisti'){
            $total_kazanc=round($calisma_saatleri*$saatlik_ucret,2);
        }
        elseif($calisma_durum=='resmi_tatil'){
            $total_kazanc=round($calisma_saatleri*$saatlik_ucret,2)*2;
        }
        elseif($calisma_durum=='mazaret_izini'){
            $cikis_yil="Mazaret İzni";
            $cikis_ay="Mazaret İzni";
            $cikis_gun="Mazaret İzni";
            $saat_farki="00:00";
            $total_kazanc=0;
            $sefer_harcirah_ucreti=0;
            $sefer_total_kazanc=0;
            $sefer_yeri="Mazaret İzni";
            $mola_saat="00:00";
        }
        elseif($calisma_durum=='raporlu'){
            $cikis_yil="Raporlu";
            $cikis_ay="Raporlu";
            $cikis_gun="Raporlu";
            $saat_farki="00:00";
            $total_kazanc=0;
            $sefer_harcirah_ucreti=0;
            $sefer_total_kazanc=0;
            $sefer_yeri="Raporlu";
            $mola_saat="00:00";
        }
        elseif($calisma_durum=='yillik_izni'){
            if($datalist11==0){
                $notification=array(
                    'message'=>$ad." ".$soyad.' yıllık izin hakkı yoktur',
                    'alert-type'=>'error'
                );

                return redirect()->route('admin_scorecard_add')->with($notification);
            }   else {


                $yapilan_izin_gun = 1;
                $kalan_yillik_izin_hakki = $datalist11 - $yapilan_izin_gun;

                if ($ay >= 1 && $ay <= 9) {
                    $trh_frmt2 = $yil . "-0" . $ay . "-0" . $giris_gun;
                } else {
                    $trh_frmt2 = $yil . "-" . $ay . "-" . $giris_gun;
                }


                $cikis_yil = "Yıllık İzin";
                $cikis_ay = "Yıllık İzin";
                $cikis_gun = "Yıllık İzin";
                $saat_farki = "00:00";
                $total_kazanc =round($saatlik_ucret*(7+(30/60)),2);
                $mola_saat = "00:00";
                $sefer_harcirah_ucreti=0;
                $sefer_total_kazanc=0;
                $sefer_yeri="Yıllık İzin";
                DB::table('truck_drivers')
                    ->where('id', $sub_id)
                    ->update(['yillik_izin_hakedis' => $kalan_yillik_izin_hakki]);


                DB::table('annual_leaves')->insert([
                    [
                        'ad' => $ad,
                        'soyad' => $soyad,
                        'tc_no' => $tc_no,
                        'yapilan_izin_gun' => $yapilan_izin_gun,
                        'kalan_yillik_izin_hakki' => $kalan_yillik_izin_hakki,
                        'izin_tarihi' => $trh_frmt2,
                        'aciklama' => $aciklama,
                        "created_at" => Carbon::now(), # new \Datetime()
                        "updated_at" => Carbon::now(),
                    ]
                ]);

            }



        }

        $sefer_total_kazanc=floatval($sefer_sayisi)*$sefer_harcirah_ucreti;








/*
print_r($aylik_total_saat);
print_r('<br/>');
print_r($saatlik_ucret);
print_r('<br/>');
print_r($total_kazanc);
exit();
*/







        $data=new ScoreCard;
        $data->ad = $ad;
        $data->soyad = $soyad;
        $data->sub_id =$sub_id;
        $data->tc_no = $tc_no;

        $data->giris_saati =$giris_saat;
        $data->cikis_saati =$cikis_saat;

        $data->giris_gun =$giris_gun;
        $data->giris_ay =$ay;
        $data->giris_yil =$yil;

        $data->cikis_gun =$cikis_gun;
        $data->cikis_ay =$cikis_ay;
        $data->cikis_yil =$cikis_yil;

        $data->saat_farki =$saat_farki;

        $data->calisma_durumu =$calisma_durum;

        $data->mola_saati =$mola_saat;

        $data->sefer_sayisi =floatval($sefer_sayisi);
        $data->sefer_ucreti =$sefer_harcirah_ucreti;
        $data->sefer_total_ucret =$sefer_total_kazanc;
        $data->sefer_yeri =$sefer_yeri;


        $data->kazandigi_total_ucret =$total_kazanc;
        $data->kazandigi_saatlik_ucret =$saatlik_ucret;
        $data->kazandigi_maas_karsiligi =$datalist;



        $data->aciklama =$aciklama;
        $data->log_id =Auth::id();
        $data->save();


        if($data){
            $notification=array(
                'message'=>'Puantaj Kaydedilmiştir.',
                'alert-type'=>'success'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }
        return redirect()->route('admin_scorecard_add')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScoreCard  $scoreCard
     * @return \Illuminate\Http\Response
     */
    public function show(ScoreCard $scoreCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScoreCard  $scoreCard
     * @return \Illuminate\Http\Response
     */
    public function edit(ScoreCard $scoreCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScoreCard  $scoreCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScoreCard $scoreCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScoreCard  $scoreCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScoreCard $scoreCard,$id,$id2)
    {
        $data=ScoreCard::find($id);
        $data->delete();

        if($data){
            $notification=array(
                'message'=>'Puantaj Silinmiştir.',
                'alert-type'=>'success'
            );
        }else{
            $notification=array(
                'message'=>'Hata Oluştu.Sistem Yöneticinizle İletişime Geçin',
                'alert-type'=>'error'
            );
        }

        return redirect()->route('admin_truckdriver_show',['id' => $id2])->with($notification);
    }
}
