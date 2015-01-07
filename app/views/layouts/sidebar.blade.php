<section class="header">
    <nav class="navbar container">
        <ul class="navbar-list">
            <li class="navbar-item"><a class="navbar-link" href="{{URL::route('home')}}">Home</a></li>
            <li class="navbar-item"><a class="navbar-link" href="{{URL::route('dashboard')}}">Dashboard</a></li>
            @if(Auth::check())
            <li class="navbar-item"><a class="navbar-link" href="{{URL::route('logout')}}">Logout</a></li>
            @endif

            @if(Route::currentRouteName() != 'home')
            <li class="navbar-item u-pull-right">
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