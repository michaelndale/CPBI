@include('layout/partiels/head')

@if(Auth::user()->menu === 0)
    @include('layout/partiels/nav')
@elseif(Auth::user()->menu=== 1)
    @include('layout/partiels/nav_second')
@else
    @include('layout/partiels/nav')
@endif

@yield('page-content')

@include('layout/partiels/copy')
@include('layout/partiels/foot')