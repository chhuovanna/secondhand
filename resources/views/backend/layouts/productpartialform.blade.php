@php
if (isset($product)){
$product_id = $product->product_id;
$name = $product->name;
$price = $product->price;
$description = $product->description;
$view_number = $product->view_number;
$status = $product->status;
$pickup_address = $product->pickup_address;
$pickup_time = $product->pickup_time;
$created_at = $product->created_at;
$updated_at = $product->updated_at;
$post_id = $product->post_id;
$image_id = $product->image_id;

}else{
$product_id = null;
$name = null;
$price = null;
$description = null;
$view_number = null;
$status = null;
$pickup_address  = null;
$pickup_time  = null;
$created_at = null; 
$updated_at = null;
$post_id = null;
$image_id = null;
}
@endphp
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
            {{ html()->label('Pickup address')//change to normal text
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

               
        <div class="form-group row">
            {{ html()->label('Thumbnail')
                ->class('col-md-2 form-control-label')
                ->for('thumbnail_id') }}

            <div class="col-md-3">


            {{ html()->input('file','thumbnail_id')
                    ->class('form-control')
                    ->placeholder('Thumbnail')
                    ->required()
                }}

            </div><!--col-->
        </div><!--form-group-->
    </div><!--col-->
    @if(isset($source))

        <div class="old-thumbnail">

            <div class="alert alert-primary alert-dismissible fade show" role="alert" >
                <input type="hidden" name="old_thumbnail" value="1">
                <img src="{{$source}}"  class="img-thumbnail" width="100px" height="100px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
</div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('Photos')
                ->class('col-md-2 form-control-label')
                ->for('photos') }}

            <div class="col-md-3">


                {{ html()->input('file','photos[]')
                        ->class('form-control')
                        ->placeholder('image')
                        ->attributes(['multiple'=>'true'])

                    }}

            </div><!--col-->
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->
