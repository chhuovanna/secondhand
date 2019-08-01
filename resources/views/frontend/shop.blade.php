@extends('frontend.layouts.indexlayout')
@section('content')

<h1>shop</h1>

@endsection


@push('after-scripts')
    <script>
        $('.active-menu').removeClass('active-menu');
        $('.menu-shop').addClass('active-menu');
    </script>
@endpush

