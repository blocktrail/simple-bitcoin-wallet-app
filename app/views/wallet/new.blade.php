@extends('layouts.master')

@section('title')
    Simple Bitcoin Wallet - New Wallet
@stop

@section('content')

    <section>
        <div class="container">
            <h1>New Wallet</h1>
            <p>
                Create a new multi-signature HD wallet to store funds in make payments with <br/>
            </p>
        </div>

        <div class="container">
            <div class="row">
                <div class="twelve columns">
                    @if( isset($newWallet) )
                        <h5 class="no-margin">Success!</h5>
                        <p>
                            Your new wallet '<b>{{ $newWallet->name }}</b>' was created!
                        </p>
                        <hr/>
                    @else
                        {{ Form::open(array('route' => 'wallet.create', 'method' => 'post', 'novalidate' => 'true')) }}
                            {{ Form::label('name', 'wallet name') }}
                            {{ Form::text('name', null, array('placeholder' => 'my wallet name', 'class' => 'u-full-width')) }}
                            <div class="error">{{ $errors->first('name') }}</div>
                            <div class="error">{{ $errors->first('general') }}</div>
                            {{ Form::submit('create', array('class' => 'button-primary u-pull-right')) }}
                            <a class="button u-pull-right margin-r" href="{{ URL::route('dashboard') }}">Cancel</a>
                        {{ Form::close() }}
                    @endif
                </div>

                @if( isset($newWallet) )
                <div class="twelve columns">
                    <h5 class="no-margin">Backup Phrase</h5>
                    <span class="section-description">Below is your backup phrase for the new wallet. Print it out and keep it in a safe place.</span>
                    <pre>
                        <code class="backup-mnemonic">
                            {{ $newWallet->backup_mnemonic }}
                        </code>
                    </pre>
                    <a class="button u-pull-right" href="{{ URL::route('dashboard') }}">Done</a>
                </div>
                @endif
            </div>
        </div>
    </section>

@stop
