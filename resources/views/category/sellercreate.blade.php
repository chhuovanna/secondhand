@extends('backend.layouts.app')

@section('title', 'Add Seller')

@section('content')


    <form action="{{ url('admin\seller\store')}}" method="post">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Seller Management
                            <small class="text-muted">Add seller</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4">
                    <div class="col">
                        <div class="form-group row">
                            <label class="col-md-1 form-control-label" for="mid" >Category:</label>

                            <div class="col-md-3">
                                <select name="id" class="form-control">
                                    @foreach ($categorys as $category) {
                                    <option value='{{ $category->id }}'>{{ $category->title}}</option>"
                                    @endforeach

                                </select>
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-1 form-control-label" for="rid" >Product:</label>

                            <div class="col-md-3">
                                <select name="id" class="form-control">
                                    @foreach ($products as $product)
                                        <option value='{{$product->id}}'>{{$product->name }}</option>
                                    @endforeach
                                </select>

                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-1 form-control-label" for="stars" >Stars:</label>

                            <div class="col-md-3">
                                <input class="form-control" type="number" min='1' max='5' name="stars" required>

                            </div><!--col-->
                        </div><!--for-->

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('seller.index'), 'Cancel') }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit('Submit') }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
        {{ html()->form()->close() }}
    </form>
@endsection