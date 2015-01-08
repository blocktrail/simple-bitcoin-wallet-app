<section class="header">
    <nav class="navbar container">
        <ul class="navbar-list">
            <li class="navbar-item"><a class="navbar-link" href="{{URL::route('dashboard')}}">Wallet</a></li>
            <li class="navbar-item"><a class="navbar-link" href="{{URL::route('explorer')}}">Explorer</a></li>
            @if(Auth::check())
            <li class="navbar-item u-pull-right"><a class="navbar-link" href="{{URL::route('logout')}}">Logout</a></li>
            @endif

            @if(Route::currentRouteName() != 'explorer')
                <li class="navbar-item u-pull-right" style="margin-right:2em">
                    {{ Form::open(array('route' => 'search', 'method' => 'get')) }}
                    {{ Form::text('query', null, array('placeholder' => 'address, block or transaction', 'class' => 'u-full-width-2')) }}
                    {{ Form::submit('search') }}
                    {{ Form::close() }}
                </li>
            @endif
        </ul>
        <div>
        </div>
    </nav>
</section>