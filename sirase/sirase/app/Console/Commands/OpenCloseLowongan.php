<?php

namespace App\Console\Commands;

use App\Models\Lowongan;
use Illuminate\Console\Command;
use Carbon\Carbon;

class OpenCloseLowongan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //ini adalah schedule buat otomatis update nanti
    protected $signature = 'app:open-close-lowongan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    //ini jaga jaga kalau misalnya kalau mau pakai ini harus php artisan app:open-close-lowongan
    public function handle()
    {
        $lowongans = Lowongan::all();
        $today = Carbon::today('Asia/Jakarta')->toDateString();
        $updated = 0;

        foreach($lowongans as $lowongan){
            $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
            $akhirPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

            //publish lowongan
            if($today >= $awalPendaftaran && $today <= $akhirPendaftaran){
                if($lowongan->status == 0){
                    $lowongan->update(['status' =>1]);
                    $updated++;
                }
            }

            //unpublishlowongan

            if($today > $akhirPendaftaran || $awalPendaftaran > $today){
                if($lowongan->status == 1){
                    $lowongan->update(['status' =>0]);
                    $updated++;
                }
            }

        }
        $this->info("Lowongan berhasil diperbarui: $updated item(s).");
        return Command::SUCCESS;
    }
}
