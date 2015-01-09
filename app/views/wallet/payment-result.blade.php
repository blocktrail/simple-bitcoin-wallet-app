@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet - Confirm Payment
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            @if(isset($transaction))
            <h1>Payment Sent!</h1>
            <p>
                Your payment was successfully sent!<br/>
                You can see it on the <a href="{{ URL::route('transaction', $transaction) }}" target="_blank">block explorer</a>.
            </p>
            <a class="button u-pull-right" href="{{ URL::route('dashboard') }}">Done</a>
            @else
                <h1>Payment Failed</h1>
                <p>
                    There was a problem sending your transaction.<br/>
                    {{ $errors->first('general') }}
                </p>
                <a class="button u-pull-right-s" href="{{ URL::route('dashboard', $wallet->id) }}">Cancel</a>
                <a class="button u-pull-right-s" href="{{ URL::route('wallet.send', $wallet->id) }}">Edit Payment</a>
            @endif
        </div>
    </section>


    <section></section>
@stop
