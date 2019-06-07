@extends('backend.layouts.app')

@section('title', 'Add Product')

@section('content')
    {{ html()->form('POST', route('product.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Product Management
                        <small class="text-muted">Add Product</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>
            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Product id')
                        ->class('col-md-2 form-control-label')
                        ->for('product_id') }}

                        <div class="col-md-3">
                            {{ html()->input('number','product_id', $product_id)
                            ->class('form-control')
                            ->placeholder('product_id')
                            ->attribute('min', 1)
                            ->readonly() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Name')
                        ->class('col-md-2 form-control-label')
                        ->for('name') }}

                        <div class="col-md-3">
                            {{ html()->text('name',$name)
                            ->class('form-control')
                            ->placeholder('name')
                            ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Price')
                        ->class('col-md-2 form-control-label')
                        ->for('price') }}

                        <div class="col-md-3">
                            {{ html()->input('number','price',$price)
                            ->class('form-control')
                            ->placeholder('price')
                            ->attributes(['min'=> 0, 'max' => 9999])
                            ->required()
                            }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Description')
                        ->class('col-md-2 form-control-label')
                        ->for('description') }}

                        <div class="col-md-3">
                            {{ html()->textarea('description',$description)
                            ->class('form-control')
                            ->placeholder('description') }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Number of View')
                        ->class('col-md-2 form-control-label')
                        ->for('view_number') }}

                        <div class="col-md-3">
                            {{ html()->input('number','view_number',$view_number)
                            ->class('form-control')
                            ->placeholder('view_number')
                            ->readonly() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Status')
                        ->class('col-md-2 form-control-label')
                        ->for('status') }}

                        <div class="col-md-3">
                            {{--{{ html()->text('status',$status)
                            ->class('form-control')
                            ->placeholder('status')
                            ->required() }}--}}


                            @php $options = ['Available'=>'Available','Sold'=>'Sold','Out of stock'=>'Out of stock']; @endphp
                            {{html()->select('status',$options)->class('form-control browser-default custom-select')}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->text('Pickup address')//change to normal text
                        ->class('col-md-2 form-control-label')
                        ->for('pickup_address')
                        }}

                        <div class="col-md-3">
                            {{ html()->textarea('pickup_address',$pickup_address)//text area
                            ->class('form-control')
                            ->placeholder('pickup_address')
                            ->required() }}

                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Available Pickup Time')
                        ->class('col-md-2 form-control-label')
                        ->for('pickup_time')
                        }}

                        <div class="col-md-3">
                            {{ html()->textarea('pickup_time',$pickup_time)
                            ->class('form-control')
                            ->placeholder('pickup_time')
                            ->required() }}

                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Created at')
                        ->class('col-md-2 form-control-label')
                        ->for('created_at') }}

                        <div class="col-md-3">
                            {{ html()->text('Created_at',$created_at)//readonly
                            ->class('form-control')
                            ->placeholder('created_at')
                             ->readonly()}}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Updated at')
                        ->class('col-md-2 form-control-label')
                        ->for('updated_at') }}

                        <div class="col-md-3">
                            {{ html()->text('updated_at',$updated_at)//readonly
                            ->class('form-control')
                            ->placeholder('updated_at')
                             ->readonly()}}
                        </div><!--col-->
                    </div><!--form-group-->

                    {{--<div class="form-group row">
                        {{ html()->label('Post_id')
                        ->class('col-md-2 form-control-label')
                        ->for('post_id') }}

                        <div class="col-md-3">
                            --}}{{--{{ html()->text('post_id',$post_id)--}}{{--
                            --}}{{--->class('form-control')--}}{{--
                            --}}{{--->placeholder('post_id')
                            ->required }}--}}{{--
                            <div class="file-field">
                                <div class="btn btn-primary btn-sm float-left">
                                    <input type="file">
                                </div>
                            </div>
                        </div><!--col-->
                    </div><!--form-group-->


    --}}

                    <div class="form-group row">
                        {{ html()->label('Thumbnail')
                            ->class('col-md-2 form-control-label')
                            ->for('image_id') }}

                        <div class="col-md-3">


                            {{ html()->input('file','image_id')
                                    ->class('form-control')
                                    ->placeholder('image')
                                    ->required()
                                }}

                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Photos')
                            ->class('col-md-2 form-control-label')
                            ->for('photos') }}

                        <div class="col-md-3">


                            {{ html()->input('file','photos')
                                    ->class('form-control')
                                    ->placeholder('image')
                                    ->attributes(['multiple'=>'true'])

                                }}

                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        {{ html()->label('Image_id')
                        ->class('col-md-2 form-control-label')
                        ->for('image_id') }}

                        <div class="col-md-3">
                            {{--{{ html()->text('image_id',$image_id)--}}
                            {{--->class('form-control')--}}
                            {{--->placeholder('image_id')
                            ->required }}--}}
                            <div class="file-field">
                                <div class="btn btn-primary btn-sm float-left">
                                    <input type="file">
                                </div>
                            </div>
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->


        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('product.index'), 'Cancel') }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit('Submit') }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    </div>
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')

    <script>
        $(document).ready(function(){

                $('#mid').select2();
                $('#rid').select2();

            });
    </script>

@endpush
