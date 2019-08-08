@extends('frontend.layouts.indexlayout')
@section('content')


tel:{{$contact->phone}}

@endsection




@push('after-scripts')
    <script>
        $('.active-menu').removeClass('active-menu');
        $('.menu-about').addClass('active-menu');
    </script>
@endpush		

	



	
