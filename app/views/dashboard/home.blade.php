@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            <h3 class="section-heading">Hi There {{ ucfirst(Auth::user()->fname) }} {{ ucfirst(Auth::user()->lname) }}</h3>
            <p>
                Ready to spend some bitcoin?
            </p>
            @if($wallets->count() > 0)
            <a class="button button-primary" href="{{ URL::route('wallet.send', $wallets[0]['id']) }}">Quick Send</a>
            <a class="button button-primary" href="{{ URL::route('wallet.receive', $wallets[0]['id']) }}">Quick Receive</a>
            @else
                <a class="button button-primary" href="{{ URL::route('wallet.create') }}">Create A Wallet</a>
            @endif
            <hr/>
        </div>
    </section>

    <section>
        <div class="container">
            <h4 class="section-heading">Wallets</h4>
            <p>You have <b>{{ $wallets->count() }}</b> wallets with a total balance of <span class="btc-value">@toBTC($totalBalance)</span> BTC</p>
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
                <tbody>
                @foreach ($wallets as $key => $wallet)
                    <tr>
                        <td>{{ $wallet['name'] }}</td>
                        <td><span class="btc-value">@toBTC($wallet['balance'])</span> BTC</td>
                        <td><span class="btc-value">@toBTC($wallet['unc_balance'])</span> BTC</td>
                        <td><a class="button" href="{{ URL::route('wallet.send', $wallet['id']) }}">Send Payment</a></td>
                        <td><a class="button" href="{{ URL::route('wallet.receive', $wallet['id']) }}">Receive Payment</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a class="button u-pull-right" style="margin-right: 3.5em;" href="{{ URL::route('wallet.create') }}">New Wallet</a>
        </div>
    </section>

    <section>
        <div class="container">
            <h4 class="section-heading">History</h4>
            <p>Below are the last 20 transaction involving your wallets.</p>

            <div class="scroll-window">
                <table class="u-full-width fixed-header transactions">
                    <thead>
                    <tr>
                        <th><div>Date</div></th>
                        <th><div>Info</div></th>
                        <th><div>Amount</div></th>
                        <th><div>Confirmations</div></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td>Date</td>
                        <td>Info</td>
                        <td>Amount</td>
                        <td>Confirmations</td>
                        <td></td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($transactions as $tx)
                        <tr>
                            <td>@datetime($tx['created_at'])</td>
                            <td>
                                @if($tx['direction'] == "sent")
                                Sent from <b>{{ $tx['wallet']['name'] }}</b> to <a href="{{ URL::route('address', $tx['recipient']) }}">{{ substr($tx['recipient'], 0, 8)}}</a>...
                                @else
                                Receieved into <b>{{ $tx['wallet']['name'] }}</b>
                                @endif
                            </td>
                            <td class="{{ $tx['amount'] > 0 ? 'output' : 'input' }}"><span class="btc-value">@toBTC($tx['amount'])</span> BTC</td>
                            <td>{{ $tx['confirmations'] }}</td>
                            <td><a href="{{ URL::route('transaction', $tx['tx_hash']) }}">view transaction</a> </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ ''//$transactions->links() }}

        </div>
    </section>

    <section></section>
@stop
