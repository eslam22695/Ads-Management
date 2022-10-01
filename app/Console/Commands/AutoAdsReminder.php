<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\AdvertiserReminder;
use App\Models\Advertiser;
use App\Models\Ads;

class AutoAdsReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:adsreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remider For Advertiser';

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
        $ads = Ads::where('start_date',date('Y-m-d', strtotime('+1 days')))->with('advertiser')->groupBy('advertiser_id')->get();
        
        if ($ads->count() > 0) {
            foreach ($ads as $ad) {
                Mail::to($ad->advertiser->email)->send(new AdvertiserReminder($ad->advertiser));
            }
        }
  
        return 0;
    }
}
