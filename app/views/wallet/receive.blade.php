@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet - Receive Payment
@stop

@section('content')

    <section>
        <div class="container">
            <h1>Receive Payment</h1>
            <p>
                Ready to receive a payment into your wallet <b>'{{ $wallet->name }}'</b>. <br/>
                Just ask the sender to make a Bitcoin transaction to your address <code>{{ $address }}</code><br/>
            </p>
            <p class="text-left">
                <a class="button" href="{{ URL::route('dashboard') }}">Done</a>
            </p>
            <hr/>
        </div>

        <div class="container">
            <div class="row">
                <div class="six columns">
                    <h4 >Scan QR Code</h4>
                    <div class="qr-code">
                        <div class="qrcode" data-qr="{{ $address }}"></div>
                    </div>
                </div>

                <div class="six columns">
                    <h4>Request By Email</h4>
                    {{ Form::open(array('route' => array('wallet.send-request', $wallet->id), 'method' => 'post', 'novalidate' => 'true')) }}
                        {{ Form::hidden('address', $address) }}

                        {{ Form::label('email', "Sender's Email") }}
                        {{ Form::email('email', Input::old('email'), array('placeholder' => 'sender@domain.com', 'class' => 'u-full-width')) }}

                        {{ Form::label('message', "Message") }}
                        {{ Form::email('message', Input::old('message'), array('placeholder' => 'optional...', 'class' => 'u-full-width')) }}
                        <div class="error u-pull-left">{{ $errors->first('email') }}</div>
                        <div class="error u-pull-left">{{ $errors->first('message') }}</div>

                        {{ Form::submit('Send Request', array('class' => 'button-primary u-pull-left')) }}
                    {{ Form::close() }}
                </div>
            </div>
            <hr/>
        </div>

    </section>

@stop

@section('footer-scripts')

    <script type="text/javascript">
        $(document).ready(function() {

            $('.qrcode').each(function() {
                var options = {
                    text: $(this).attr('data-qr')
                };
                console.log(this);
                $(this).qrcode(options);
            });
        });
    </script>
@stop
