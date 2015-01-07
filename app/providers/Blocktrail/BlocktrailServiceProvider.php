<?php namespace App\Providers\Blocktrail;

use Blocktrail\SDK\BlocktrailSDK;
use Illuminate\Support\ServiceProvider;

class BlocktrailServiceProvider extends ServiceProvider {


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('blocktrail', function($app)
        {
            //$apiCredentials = Config::get('services.blocktrail', ['MY_API_KEY','MY_API_SECRET']);
            $serviceConfig = $app['config']['services.blocktrail'];
            $apiKey = $serviceConfig['key'];
            $apiSecret = $serviceConfig['secret'];
            $currency = $serviceConfig['currency'];
            $testnet = $serviceConfig['testnet'];

            //echo"called";exit;

            $bitcoinClient = new BlocktrailSDK($apiKey, $apiSecret, $currency, $testnet);
            if($serviceConfig['disable_ssl']) {
                $bitcoinClient->setCurlDefaultOption('verify', false); //disable ssl verification, use for local testing only
            }

            return $bitcoinClient;
        });
    }

}