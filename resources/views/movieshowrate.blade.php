@extends('backend.layouts.app')

@section('title', 'Show Rate')

@section('content')



<form  method="post">
    @csrf
	<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Movie Managment
                        <small class="text-muted">Show Rate</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Movie')
                            ->class('col-md-1 form-control-label')
                            ->for('mid') }}

                        <div class="col-md-3">
                             <select name="mid" id="mid" class="form-control" >
                                @foreach ($movies as $movie) {
                                    <option value='{{ $movie->mID }}'>{{ $movie->title}}</option>"
                                @endforeach
                                
                            </select>
                        </div><!--col-->
                    </div><!--form-group-->
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">

	            	<div id="result"></div>	
	            </div>
	        </div>
        </div>
    </div>

{{ html()->form()->close() }}
@endsection

@push('after-scripts')

<script>

    $('#mid').off('change');
    $('#mid').on('change', function(){
    	//alert('change');
        $.ajax({
                type:"GET",
                url:"getrating",
                data:{mid: parseInt($('#mid').val())},    
                success: function (data) {
                    console.log(data);
                    $('#result').html(data);
                }, 
                error: function(data){
                    console.log(data);
                }
            });
    });

</script>

@endpush