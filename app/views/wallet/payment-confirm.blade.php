@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet - Confirm Payment
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            <div class="row">
                <div class="eight offset-by-two columns">
                    <h1 class="text-center">Please Confirm</h1>
                    <p>
                        You are about to make a payment of {{ $amount }} Satoshi (
                        <span class="btc-value">@toBTC($amount)</span> BTC
                        ) to the address <code>{{ $address }}</code>. <br/>
                        Please enter in your password below to continue with this payment.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="eight offset-by-two columns">
                    {{ Form::open(array('route' => array('wallet.confirm-send', $wallet->id), 'method' => 'post', 'novalidate' => 'true')) }}
                        {{ Form::hidden('address', Input::old('address'), array('placeholder' => 'bitcoin address', 'class' => 'u-full-width')) }}
                        {{ Form::hidden('amount', Input::old('amount'), array('placeholder' => 'amount', 'class' => 'u-full-width')) }}
                        {{ Form::password('password',  array('placeholder' => 'password', 'class' => 'u-full-width')) }}
                        <div class="error">{{ $errors->first('password') }}</div>
                        <div class="error u-pull-left">{{ $errors->first('general') }}</div>

                        {{ Form::submit('Make Payment', array('class' => 'button-primary u-pull-right')) }}
                        <a class="button u-pull-right margin-r" href="{{ URL::route('wallet.send', $wallet->id) }}">Cancel</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>

@stop
