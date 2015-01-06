@extends('layouts.master')

@section('title')
    Explorer - Transaction {{$hash}}
@stop
@section('content')

    <section>
        <div class="container">
            <h1>Bitcoin Transaction</h1>
            <div>{{$hash}}</div>
        </div>
    </section>

    <section>
        <div class="container">
            <h2 class="section-heading">Summary</h2>
            <div class="row">
                <div class="four columns"><b>Estimated Value: </b><span class="btc-value">@toBTC($estimated_value)</span> BTC</div>
                <div class="three columns"><b>Confirmations: </b>{{$confirmations}}</div>
                <div class="three columns"><b>Seen: </b>@datetime($first_seen_at)</div>
            </div>
            <div class="row">
                <div class="four columns"><b>Transaction Fee: </b><span class="btc-value">@toBTC($total_fee)</span> BTC</div>
                @if ($block_hash)
                <div class="three columns"><b>Block: </b>#<a href="{{ URL::route('block', $block_hash) }}">{{$block_height}}</a></div>
                @endif
            </div>
        </div>
    </section>

    <section class="address-transactions">
        <div class="container">
            <div class="row">
                <div class="one-third column">
                    <h2>Inputs</h2>
                    <div><b>Total:</b> {{ count($inputs) }}</div>
                    <div><b>Amount:</b> <span class="btc-value">@toBTC($total_input_value)</span> BTC</div>
                </div>
                <div class="two-thirds column scroll-window">
                    <table class="u-full-width fixed-header inputs">
                        <thead>
                            <tr>
                                <th><div>Amount <small>(Satoshi)</small></div></th>
                                <th><div>Sender</div></th>
                                <th><div>Original Tx</div></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td>Amount <small>(Satoshi)</small></td>
                                <td>Sender</td>
                                <td>Original Tx</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($inputs as $input)
                            <tr>
                                <td class="input">{{$input['value']}}</td>
                                <td>
                                    @if($input['address'])
                                    <a href="{{ URL::route('address', $input['address']) }}">{{ substr($input['address'], 0, 8)}}</a>...
                                    @else
                                    - 
                                    @endif
                                </td>
                                <td>
                                    @if($input['output_hash'])
                                    <a href="{{ URL::route('transaction', $input['output_hash']) }}">{{ substr($input['output_hash'], 0, 8)}}</a>...
                                    @else
                                    coinbase
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <section class="address-transactions">
        <div class="container">
            <div class="row">
                <div class="one-third column">
                    <h2>Outputs</h2>
                    <div><b>Total:</b> {{ count($outputs) }}</div>
                    <div><b>Amount:</b> <span class="btc-value">@toBTC($total_output_value)</span> BTC</div>
                </div>
                <div class="two-thirds column scroll-window">
                    <table class="u-full-width fixed-header outputs">
                        <thead>
                            <tr>
                                <th><div>Amount <small>(Satoshi)</small></div></th>
                                <th><div>Recipient</div></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td>Amount <small>(Satoshi)</small></td>
                                <td>Recipient</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($outputs as $output)
                            <tr>
                                <td class="output">{{$output['value']}}</td>
                                <td><a href="{{ URL::route('address', $output['address']) }}">{{ substr($output['address'], 0, 8)}}</a>...</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
