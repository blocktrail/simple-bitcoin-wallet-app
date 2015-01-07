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
        $this->app->singleton(array('Blocktrail' => 'Blocktrail\SDK\BlocktrailSDK'), function($app)
        {
            $serviceConfig = $app['config']['services.blocktrail'];
            $apiKey = $serviceConfig['key'];
            $apiSecret = $serviceConfig['secret'];
            $currency = $serviceConfig['currency'];
            $testnet = $serviceConfig['testnet'];

            $bitcoinClient = new BlocktrailSDK($apiKey, $apiSecret, $currency, $testnet);
            if($serviceConfig['disable_ssl']) {
                $bitcoinClient->setCurlDefaultOption('verify', false); //disable ssl verification, use for local testing only
            }

            return $bitcoinClient;
        });
    }

}