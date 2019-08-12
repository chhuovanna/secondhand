@extends('frontend.layouts.indexlayout')
@section('content')


<!DOCTYPE html>
<html>
<body>

<div class="container" style="padding:30px;">

	<h5>INFORMATION</h5>
<table class="label">
<tr><td class="text-left"><i class="fa fa-phone" style="font-size:24px"></i>
    		+855 023 / 81 881 887</td></tr>
<tr><td class="text-left"><i class="fa fa-envelope" style="font-size:24px"></i>
    		info@ctr-system.com</td></tr>
<tr><td class="text-left"><i class="fa fa-globe" style="font-size:24px"></i>
    		www.ctr-system.com</td></tr>
<tr><td class="text-left"><i class="fa fa-map-marker" style="font-size:24px"></i>
    		St 259, Sangkat Toek Laak 1, Khan Toul Kork,<br> Phnom Penh, Cambodia.</td></tr>
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

	



	
