@extends('layouts.master')

@section('title')
    Simple Bitcoin
@stop

@section('sidebar')
@stop

@section('content')

    <section>
        <div class="container">
            <h1>{{$title}}</h1>
        </div>
    </section>

    <section>
        <div class="container">
            <h2 class="section-heading">{{$subtitle}}</h2>
            <p>{{$message}}</p>
        </div>
    </section>

    <section></section>
@stop
