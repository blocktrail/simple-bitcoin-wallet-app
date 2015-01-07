@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            <h1>Dashboard</h1>
        </div>
    </section>

    <section>
        <div class="container">
            <h4 class="section-heading">Hi There {{ ucfirst(Auth::user()->fname) }}</h4>
            <p>
                Ready to spend some bitcoins?
            </p>

            <hr/>
            @foreach($wallets as $key => $wallet)
                <div class="margin-b">
                    <h5 class="no-margin">Wallet {{ $key+1 }}</h5>
                    <div><b></b> <span class="btc-value">@toBTC($wallet['balance'])</span> BTC</div>
                </div>
            @endforeach

        </div>
    </section>

    <section></section>
@stop
