@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            <h1></h1>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="six offset-by-three columns">
                    <h2 class="section-heading">Login</h2>
                    @if($errors->count() > 0)
                        <h6>Please check your input</h6>
                    @endif
                    {{ Form::open(array('route' => 'login', 'method' => 'post', 'novalidate' => 'true')) }}
                    <div class="error">{{ $errors->first('email') }}</div>
                    {{ Form::email('email', Input::old('email'), array('placeholder' => 'you@domain.com', 'class' => 'u-full-width')) }}
                    <div class="error">{{ $errors->first('password') }}</div>
                    {{ Form::password('password',  array('placeholder' => 'password', 'class' => 'u-full-width')) }}
                    {{ Form::submit('login', array('class' => 'u-pull-right')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>

    <section></section>
@stop
