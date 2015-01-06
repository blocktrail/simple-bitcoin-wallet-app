@extends('layouts.master')

@section('title')
    A Simple Block Explorer
@stop

@section('content')

    <section>
        <div class="container">
            <h1>A Simple Block Explorer</h1>
            <p>
                A working example of the <a href="https://www.blocktrail.com/" target="_blank">BlockTrail API</a> used to create a simple Bitcoin block explorer.
            </p>
            {{ Form::open(array('route' => 'search', 'method' => 'get')) }}
                <div class="row">
                    <div class="ten columns">
                        {{ Form::text('query', null, array('placeholder' => 'address, block hash/height or transaction', 'class' => 'u-full-width')) }}
                    </div>
                    <div class="two columns">
                        {{ Form::submit('search', array('class' => 'button button-primary')) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </section>

    <section>
        <div class="container">
            <h3 class="section-heading">Latest Bitcoin Blocks</h3>
            <table class="u-full-width blocks">
                <thead>
                    <tr>
                        <th><div>Height</div></th>
                        <th><div>Time</div></th>
                        <th><div>Transactions</div></th>
                        <th><div>Size</div></th>
                        <th><div></div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blocks['data'] as $block)
                    <tr>
                        <td>#{{$block['height']}}</td>
                        <td>@datetime($block['block_time'])</td>
                        <td>{{$block['transactions']}}</td>
                        <td>{{$block['byte_size']}} bytes</td>
                        <td><a href="{{ URL::route('block', $block['hash']) }}">View Block</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
