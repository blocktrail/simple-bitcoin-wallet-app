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
            <h4 class="section-heading">Hi there {{ Auth::user()->fname }}</h4>
        </div>
    </section>

    <section></section>
@stop
