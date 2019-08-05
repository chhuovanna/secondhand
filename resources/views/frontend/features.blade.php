@extends('frontend.layouts.indexlayout')
@section('content')

@endsection


@push('after-scripts')
    <script>
        $('.active-menu').removeClass('active-menu');
        $('.menu-features').addClass('active-menu');
    </script>
@endpush
