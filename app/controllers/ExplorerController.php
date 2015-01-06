<?php

class ExplorerController extends BaseController {

    private $bitcoinClient;

    public function __construct() {

        //initialise the BlocTrail API
        $apiCredentials = Config::get('services.blocktrail', ['MY_API_KEY','MY_API_SECRET']);
        $apiKey = $apiCredentials['key'];
        $apiSecret = $apiCredentials['secret'];
        $currency = "btc";
        $this->bitcoinClient = new Blocktrail($apiKey, $apiSecret, $currency, false);
        $this->bitcoinClient->setCurlDefaultOption('verify', false); //disable ssl verification, for local testing
    }

    public function showHome()
    {
        try {
            //get the latest few blocks
            $blocks = $this->bitcoinClient->allBlocks($page = 1, $limit = 5, $sortDir = 'desc');

            //create the view, passing the data
            $data = array('blocks' => $blocks);
            return View::make('explorer.home', $data);

        } catch(Exception $e) {
            $data = array(
                "title"    => "",
                "subtitle" => "An Error Ocurred",
                "message" => $e->getMessage(),
            );
            return View::make('error.general', $data);
        }
    }

    public function showAddress($address)
    {
        try {
            //get the address data
            $addressInfo = $this->bitcoinClient->address($address);
            //get the address transactions
            $page = Input::get('page', 1);
            $transactions = $this->bitcoinClient->addressTransactions($address, $page, $limit=20, $sortDir='desc');

            //create an instance of the Paginator for easy pagination of the results
            $transactions = Paginator::make($transactions['data'], $transactions['total'], $transactions['per_page']);
            
            $data = array('summary' => $addressInfo, 'transactions' => $transactions);
            return View::make('explorer.address', $data);

        } catch(Exception $e) {
            $data = array(
                "title"    => "Bitcoin Address",
                "subtitle" => "Could Not Get Address Data",
                "message" => $e->getMessage(),
            );
            return View::make('error.general', $data);
        }
    }

    public function showTransaction($txhash)
    {
        try {
            //get the transaction data
            $data = $this->bitcoinClient->transaction($txhash);

            return View::make('explorer.transaction', $data);

        } catch(Exception $e) {
            $data = array(
                "title"    => "Bitcoin Transaction",
                "subtitle" => "Could Not Get Transaction Data",
                "message" => $e->getMessage(),
            );
            return View::make('error.general', $data);
        }
    }

    public function showBlock($block)
    {
        try {
            //get the block data
            $blockInfo = $this->bitcoinClient->block($block);
            //get the block transactions
            $page = Input::get('page', 1);
            $transactions = $this->bitcoinClient->blockTransactions($block, $page, $limit=20, $sortDir='desc');

            //create an instance of the Paginator for easy pagination of the results
            $transactions = Paginator::make($transactions['data'], $transactions['total'], $transactions['per_page']);
            
            $data = array('block' => $blockInfo, 'transactions' => $transactions);
            return View::make('explorer.block', $data);

        } catch(Exception $e) {
            $data = array(
                "title"    => "Bitcoin Block",
                "subtitle" => "Could Not Get Block Data",
                "message" => $e->getMessage(),
            );
            return View::make('error.general', $data);
        }
    }


    public function search()
    {
        if(Input::get('query')) {
            //detect what is being searched for
            $query = Input::get('query');

            $addressRegex = "/^[13][a-km-zA-HJ-NP-Z0-9]{25,34}$/i";
            $blockHashRegex = "/^[0-9a-f]{64}$/i";
            $txHashRegex = "/^[0-9a-f]{64}$/i";
            $blockHeightRegex = "/^[0-9]+$/i";

            if(preg_match($addressRegex, $query)) {
                //go to address
                return Redirect::route('address', $query);
            } else if( (preg_match($blockHashRegex, $query) && strpos($query, "00000000") === 0) || preg_match($blockHeightRegex, $query)) {
                //go to block
                return Redirect::route('block', $query);
            } else if(preg_match($txHashRegex, $query)) {
                //go to transaction
                return Redirect::route('transaction', $query);
            } else {
                //no matching pattern
                $data = array(
                    "title"    => "",
                    "subtitle" => 'No search results for "'.$query.'"',
                    "message" => "please check your input, it doesn't appear to be an address, block hash or block height",
                );
                return View::make('error.search', $data);
            }
        }

        //no search input
        $data = array(
            "title"    => "",
            "subtitle" => "No search results ",
            "message" => "please enter an address hash, block hash or height",
        );
        return View::make('error.search', $data);
    }

}
