@extends('layouts.master')

@section('title')
    Search Results
@stop

@section('sidebar')
    <p>This is appended to the master sidebar.</p>
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
            
            {{ Form::open(array('route' => 'search', 'method' => 'get')) }}
                <div class="row">
                    <div class="ten columns">
                        {{ Form::text('query', null, array('placeholder' => 'address hash, block hash or height', 'class' => 'u-full-width')) }}
                    </div>
                    <div class="two columns">
                        {{ Form::submit('search', array('class' => 'button button-primary')) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </section>

    <section></section>
@stop
