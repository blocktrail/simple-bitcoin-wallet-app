<?php

use Illuminate\Support\MessageBag;

class WalletController extends BaseController {

    private $bitcoinClient;

    public function __construct(Blocktrail $client) {
        $this->bitcoinClient = $client;
    }

    public function showNewWallet()
    {
        return View::make('wallet.new');
    }

    public function createNewWallet()
    {
        //validate input
        $rules = array(
            'name' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //bad input
            return Redirect::route('wallet.create')->withErrors($validator);
        }

        //create new wallet
        $user = Auth::user();
        $walletData = array(
            'identity' => str_random(40),
            'name' => Input::get('name'),
            'pass' => str_random(6),
            'user_id' => $user->id
        );
        $wallet = New Wallet($walletData);
        if ($wallet->save()) {
            //wallet created - delete the backup mnemonic from the database
            Wallet::where('ID', $wallet->id)->update(array('backup_mnemonic' => null));
            $data = array(
                'newWallet' => $wallet
            );

            //create a webhook for this wallet
            if (App::environment('production')) {
                $url = URL::route('webhook', array('wallet_identity' => $wallet->identity));
            } else {
                //Using an ngrok to create a tunnel from a public domain to our local env (https://ngrok.com) and set as app url (in app.php config file)
                $url = Config::get('app.url').'/webhook/'.$wallet->identity;
            }
            //add basic auth to url for webhook user
            $url = str_replace('://', '://webhook:OxGKbaxYmvCumi@', $url);
            $newWebhook = Webhook::create(array('identifier' => $wallet->identity, 'url' => $url, 'wallet_id' => $wallet->id));

            //return the view with new wallet data
            return View::make('wallet.new')->with($data)->withErrors(Session::get('webhook-error'));
        } else {
            //could not create wallet
            return View::make('wallet.new')->withErrors(Session::get('wallet-error'));
        }
    }

    public function showWallet($wallet)
    {
        $data = [];
        return View::make('wallet.edit')->with($data);
    }

    public function updateWallet($wallet)
    {
        //
    }

    public function showSendPayment($wallet)
    {
        $wallet->getBalance();
        $data = [
            'wallet' => $wallet
        ];
        return View::make('wallet.send')->with($data);
    }

    public function sendPayment($wallet)
    {
        //Validate the input then send the user to confirm the payment
        $rules = array(
            'address' => 'required|regex:/^[a-km-zA-HJ-NP-Z0-9]{26,35}$/i',
            'amount' => 'required|integer|min:1'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //bad input
            return Redirect::route('wallet.send', $wallet->id)->withInput()->withErrors($validator);
        }

        //flash the input for next request, and show the confirmation view
        Input::flash();
        $data = [
            'wallet' => $wallet,
            'address' => Input::get('address'),
            'amount' => Input::get('amount'),
        ];
        return View::make('wallet.payment-confirm')->with($data);

    }

    public function confirmPayment($wallet)
    {
        //validate wallet owners' password
        if (!Hash::check(Input::get('password'), Auth::user()->password) ) {
            Input::flashExcept('password');
            $data = [
                'wallet' => $wallet,
                'address' => Input::get('address'),
                'amount' => Input::get('amount'),
            ];
            $errors =  new MessageBag(array('general' => 'Password is incorrect'));
            return View::make('wallet.payment-confirm')->with($data)->withErrors($errors);
        }

        //send off the payment
        try {
            $transaction = $wallet->pay(Input::get('address'), Input::get('amount'));
            $data = [
                'transaction' => $transaction
            ];

            //subscribe to webhook event for the recipient address
            try {
                $wallet->webhook->subscribeAddressTransactions(Input::get('address'));
            } catch (Exception $e) {
                //
            }

            //add to the Transaction table
            $txData = array(
                'tx_hash' => $transaction,
                'tx_time' => Carbon::now(),
                'address' => null,
                'recipient' => Input::get('address'),
                'direction' => "sent",
                'amount' => -Input::get('amount'),
                'confirmations' => 0,
                'wallet_id' => $wallet->id,
            );
            Transaction::firstOrCreate($txData);

            //redirect to the success page (to avoid resubmitting payment on refresh)
            return Redirect::route('wallet.payment-result', $wallet->id)->withData($data);
        } catch (Exception $e) {
            //an error occurred
            Input::flashExcept('password');
            $data = [
                'wallet' => $wallet,
            ];
            $errors =  new MessageBag(array('general' => $e->getMessage()));
            return View::make('wallet.payment-result')->with($data)->withErrors($errors);
        }
    }

    public function showPaymentResult($wallet)
    {
        //use an extra route here to ensure refreshing the page doesn't re-send the payment
        $data = Session::get('data');
        if (isset($data['transaction'])) {
            //payment was successful
            return View::make('wallet.payment-result')->with($data);
        } else {
            return Redirect::route('dashboard');
        }
    }

    public function showReceivePayment($wallet)
    {
        //get a new address to receive payments to
        $address = $wallet->getNewAddress();
        //create a webhook event listening to the new address
        $wallet->webhook->subscribeAddressTransactions($address);
        $data = [
            'wallet' => $wallet,
            'address' => $address
        ];
        return View::make('wallet.receive')->with($data);
    }

    public function sendPaymentRequest($wallet)
    {
        $data = [
            'wallet' => $wallet,
            'address' => Input::get('address')
        ];

        //validate input
        $rules = array(
            'email' => 'required|email',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //bad input
            Input::flash();
            return View::make('wallet.receive')->with($data)->withErrors($validator);
        }

        //send email
        $mailData = array(
            'recipient_email' => Input::get('email'),
            'payee_fname' => Auth::user()->fname,
            'payee_lname' => Auth::user()->lname,
            'payee_email' => Auth::user()->email,
            'msg'         => Input::get('message'),
            'address'     => Input::get('address'),
        );

        //return View::make('emails.wallet.request', $mailData);
        Mail::send('emails.wallet.request', $mailData, function($message) use($mailData){
            $message->from($mailData['payee_email'], $mailData['payee_fname'].' '.$mailData['payee_lname']);
            $message->to($mailData['recipient_email'])->subject('Please sent funds to my Bitcoin wallet');
        });

        //success
        return View::make('wallet.receive')->with($data)->with('email_sent', 'Request sent successfully');
    }

}
