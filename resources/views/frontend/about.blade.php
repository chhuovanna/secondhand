@extends('frontend.layouts.indexlayout')
@section('content')


<!DOCTYPE html>
<html>
<body>

<div class="container" style="padding:30px;">

	<h5>INFORMATION</h5>
<table class="label">
<tr><td class="text-left"><i class="fa fa-phone" style="font-size:24px"></i>
    		{{$about->phone}}</td></tr>
<tr><td class="text-left"><i class="fa fa-envelope" style="font-size:24px"></i>
    		{{$about->email}}</td></tr>
<tr><td class="text-left"><i class="fa fa-globe" style="font-size:24px"></i>
    		{{$about->website}}</td></tr>
<tr><td class="text-left"><i class="fa fa-map-marker" style="font-size:24px"></i>
    		{{$about->address}}</td></tr>
</table>


</div>
  
  	
  
  
  


</body>
</html>


@endsection




@push('after-scripts')
    <script>
        $('.active-menu').removeClass('active-menu');
        $('.menu-about').addClass('active-menu');
    </script>
@endpush		

	



	
