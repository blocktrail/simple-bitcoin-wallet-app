@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet - Send Payment
@stop

@section('content')

    <section>
        <div class="container">
            <div class="row">
                <div class="eight offset-by-two columns">
                    <h1>Send Payment</h1>
                    <p>
                        Ready to send a payment from your wallet <b>'{{ $wallet->name }}'</b>. <br/>
                        You have a confirmed balance of <span class="btc-value">@toBTC($wallet->balance)</span> BTC <br/>
                        @if($wallet->unc_balance)
                            <small>there is <span class="btc-value">@toBTC($wallet->unc_balance)</span> BTC in pending transactions</small>
                        @endif
                    </p>
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="eight offset-by-two columns">
                    {{ Form::open(array('route' => array('wallet.send', $wallet->id), 'method' => 'post', 'novalidate' => 'true')) }}

                    {{ Form::label('address', "Recipient Address") }}
                    {{ Form::text('address', Input::old('address'), array('placeholder' => 'bitcoin address', 'class' => 'u-full-width')) }}

                    {{ Form::label('amount', "Amount in Satoshi") }}
                    <div><small><i>1BTC = 100000000 Satoshi</i></small></div>
                    {{ Form::number('amount', Input::old('amount'), array('placeholder' => 'amount', 'class' => 'u-full-width')) }}

                    <div class="error u-pull-left">
                        <div>{{ $errors->first('address') }}</div>
                        <div>{{ $errors->first('amount') }}</div>
                        <div>{{ $errors->first('general') }}</div>
                    </div>

                    {{ Form::submit('Send Payment', array('class' => 'button-primary u-pull-right')) }}
                    <a class="button u-pull-right margin-r" href="{{ URL::route('dashboard') }}">Cancel</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </section>

@stop