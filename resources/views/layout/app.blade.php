@include('layout/partiels/head')

@php
    $service = session('service');
@endphp

@if(is_null($service))
    <script type="text/javascript">
        window.location.href = "{{ route('start') }}";
    </script>
@endif


@if(Auth::user()->menu === 0 && $service == 1)
    @include('layout/partiels/nav_projet_verticale')

@elseif (Auth::user()->menu === 0 && $service == 2)
    @include('layout/partiels/nav_rh_verticale')

@elseif (Auth::user()->menu === 0 && $service == 3)
    @include('layout/partiels/nav_archivage_verticale')

@elseif (Auth::user()->menu === 0 && $service == 4)
    @include('layout/partiels/nav_parc_verticale')

@elseif(Auth::user()->menu === 1)

@include('layout/partiels/nav_second')
@else
    @include('layout/partiels/nav')
@endif

@yield('page-content')

@include('layout/partiels/copy')
@include('layout/partiels/foot')
