@extends('layouts.master')

@section('title')
    Explorer - Block {{$block['hash']}}
@stop

@section('content')

    <section>
        <div class="container">
            <h1>Bitcoin Block</h1>
            <div>{{$block['hash']}}</div>
        </div>
    </section>

    <section>
        <div class="container">
            <h2 class="section-heading">Summary</h2>
            <div class="row">
                <div class="three columns"><b>Block Time: </b>@datetime($block['block_time'])</div>
                <div class="three columns"><b>Height:</b> {{$block['height']}}</div>
                <div class="three columns"><b>Transactions:</b> {{$block['transactions']}}</div>
                <div class="three columns"><b>Size:</b> {{$block['byte_size']}} bytes</div>
            </div>
            <div class="row">
                <div class="three columns"><b>Confirmations:</b> {{$block['confirmations']}}</div>
                <div class="three columns"><b>Orphaned:</b> {{$block['is_orphan'] ? 'yes' : 'no'}}</div>
            </div>
            <div class="row margin-t">
                <div class="three columns">
                    @if($block['prev_block'])
                    <b>Previous: </b>#<a href="{{ URL::route('block', $block['prev_block']) }}">{{$block['height']-1}}</a>
                    @endif
                </div>
                <div class="three columns">
                    @if($block['next_block'])
                    <b>Next: </b>#<a href="{{ URL::route('block', $block['next_block']) }}">{{$block['height']+1}}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="block-transactions">
        <div class="container">
            <div class="row">
                <div class="one-third column">
                    <h2>Transactions</h2>
                    <div class="row">
                        <div><b>Total Transactions:</b> {{$block['transactions']}}</div>
                        <div><b>Value:</b> <span class="btc-value">@toBTC($block['value'])</span> BTC</div>
                    </div>
                </div>
                <div class="two-thirds column">
                    <div class="scroll-window">
                        <table class="u-full-width fixed-header transactions">
                            <thead>
                                <tr>
                                    <th><div>Total Input</div></th>
                                    <th><div>Total Output</div></th>
                                    <th><div>Transaction Fee</div></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td>Total Input</td>
                                    <td>Total Output</td>
                                    <td>Transaction Fee</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($transactions as $tx)
                                <tr>
                                    <td>{{$tx['total_input_value']}}</td>
                                    <td>{{$tx['total_output_value']}}</td>
                                    <td class="input">{{$tx['total_fee']}}</td>
                                    <td><a href="{{ URL::route('transaction', $tx['hash']) }}">view transaction</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <hr>
            <h3 class="section-heading">Need help getting started?</h3>
            <p class="section-description">BlockTrail is an amazingly easy place to start with Bitcoin development. If you want to learn more, just visit the documentation!</p>
            <a class="button button-primary" href="https://www.blocktrail.com/api/docs" target="_blank">View BlockTrail Docs</a>
        </div>
    </section>

    <section></section>
@stop
