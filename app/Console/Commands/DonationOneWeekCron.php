<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AdminDonation;
use App\Models\Donation;

class DonationOneWeekCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donateEveryOneWeek:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");
     
        $donations = Donation::where('status', 'accept')->where('type', 'one_week')->where('admin_id', '<>', null)->get();
        foreach ($donations as $donation) {
            $donation->admin->notify(new AdminDonation($donation));
        }
      
        $this->info('donate:Cron Cummand Run successfully!');
    }
}
