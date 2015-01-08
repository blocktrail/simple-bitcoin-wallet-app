@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            <h3 class="section-heading">Hi There {{ ucfirst(Auth::user()->fname) }}</h3>
            <p>
                Ready to spend some bitcoin?
            </p>

            <hr/>
        </div>
    </section>

    <section>
        <div class="container">
            <h4 class="section-heading">Wallets</h4>
            <table class="u-full-width blocks">
                <thead>
                <tr>
                    <th><div>Name</div></th>
                    <th><div>Balance</div></th>
                    <th><div>Pending Transactions</div></th>
                    <th><div></div></th>
                    <th><div></div></th>
                </tr>
                </thead>
                <!--
                <tfoot>
                    <tr>
                        <td></td>
                        <td>Total: <span class="btc-value">@toBTC($totalBalance)</span> BTC</td>
                        <td>Total: <span class="btc-value">@toBTC($totalUncBalance)</span> BTC</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
                -->
                <tbody>
                @foreach ($wallets as $key => $wallet)
                    <tr>
                        <td>{{ $wallet['name'] }}</td>
                        <td><span class="btc-value">@toBTC($wallet['balance'])</span> BTC</td>
                        <td><span class="btc-value">@toBTC($wallet['unc_balance'])</span> BTC</td>
                        <td><a href="{{ URL::route('wallet.receive', $wallet['id']) }}">Send Payment</a></td>
                        <td><a href="{{ URL::route('wallet.send', $wallet['id']) }}">Receive Payment</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

@stop
