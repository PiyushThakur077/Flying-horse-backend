<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateCurrencyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateCurrencyRate';

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
     * @return int
     */
    public function handle()
    {
        $key = config('services.conversion_key');
   
        $data = Http::get("https://v6.exchangerate-api.com/v6/{$key}/latest/USD");

        $response = $data->json();
      
        foreach( $response['conversion_rates'] as $key => $val )
        {
            Currency::where('code', $key)->update(['rateToBase' => $val]);
        }

        $data = Http::get("http://api.coinlayer.com/live",[
            'access_key' => config('services.crypto_conversion_key'),
            'target' => 'USD',
            'symbols' => 'BTC,ALGO,ETH,MTL,DOGE,ALGO'
        ]);
        
        $response = $data->json();

        // dd( $response['rate']);
        foreach( $response['rates'] as $key => $val ){
            Currency::where('code', $key)->update(['rateToBase' => $val]);
        }

        $this->info(" Successfully updated currency rates at". date('Y-m-d H:i:s'));

    }
}
