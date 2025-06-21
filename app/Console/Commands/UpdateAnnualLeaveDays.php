<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateAnnualLeaveDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:annual-leave-days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update annual leave days for users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now();
        $datalist = DB::table( 'annual_leave_control')->get();
        $yapilan_izin_gun=0;


        foreach ($datalist as $kontrol) {
            if ($today->isSameDay($kontrol->gelecek_izin_tarihi)) {
                $datalist2 = DB::table('truck_drivers')->where('ad', '=', $kontrol->ad)->where('soyad', '=', $kontrol->soyad)->where('tc_no', '=', $kontrol->tc_no)->value('yillik_izin_hakedis');
                $datalist3 = DB::table('annual_leave_control')->where('ad', '=', $kontrol->ad)->where('soyad', '=', $kontrol->soyad)->where('tc_no', '=', $kontrol->tc_no)->value('gelecek_izin_tarihi');
                $guncelleme_kontrol = $this->calculateAnnualLeaveDays($kontrol->dogum_tarihi, $kontrol->start_date);

                $guncelleme_yillik_izin = $datalist2 + $guncelleme_kontrol;
                $aciklama = $guncelleme_kontrol . "gün izin hakkı eklenmiştir.";

                $date4=Carbon::parse($datalist3);
                $yeniTarih = $date4->addYear();
                $date5=$yeniTarih->toDateString();



                DB::table('truck_drivers')
                    ->where('ad', $kontrol->ad)
                    ->where('soyad', $kontrol->soyad)
                    ->where('tc_no', $kontrol->tc_no)
                    ->update(['yillik_izin_hakedis' => $guncelleme_yillik_izin]);


                DB::table('annual_leaves')->insert([
                    [
                        'ad' => $kontrol->ad,
                        'soyad' => $kontrol->soyad,
                        'tc_no' => $kontrol->tc_no,
                        'yapilan_izin_gun' => $yapilan_izin_gun,
                        'kalan_yillik_izin_hakki' => $guncelleme_yillik_izin,
                        'aciklama' => $aciklama,
                        "created_at" => Carbon::now(), # new \Datetime()
                        "updated_at" => Carbon::now(),
                    ]
                ]);

                DB::table('annual_leave_control')
                    ->where('ad', $kontrol->ad)
                    ->where('soyad', $kontrol->soyad)
                    ->where('tc_no', $kontrol->tc_no)
                    ->update(['gelecek_izin_tarihi' => $date5]);


                $this->info($today.'Yıllık izini Güncellendi: ' . $kontrol->ad);


            }


        }
    }


    private function calculateAnnualLeaveDays($birthDate, $startDate)
    {
        $currentDate = Carbon::now();
        $startYearDiff = $currentDate->diffInYears(Carbon::parse($startDate));
        $age = $currentDate->diffInYears(Carbon::parse($birthDate));

        if($startYearDiff >= 1){
            if ($age >= 50) {
                if ($startYearDiff <= 15) {
                    return 20;
                } else {
                    return 26;
                }
            }else{
                if ($startYearDiff >= 1 && $startYearDiff < 6) {
                    return 14;
                } elseif ($startYearDiff >= 6 && $startYearDiff < 15) {
                    return 20;
                } elseif ($startYearDiff >= 15) {
                    return 26;
                }
            }}

        return 0;
    }









}
