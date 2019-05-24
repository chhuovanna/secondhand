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
            {{ html()->label('product_id')
            ->class('col-md-2 form-control-label')
            ->for('product_id') }}

            <div class="col-md-3">
                {{ html()->input('number','product_id', $product_id)
                ->class('form-control')
                ->placeholder('product_id')
                ->attribute('min', 1)
                ->required()
                ->autofocus() }}
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
            ->for('address') }}

            <div class="col-md-3">
                {{ html()->input('number','price',$price)
                ->class('form-control')
                ->placeholder('price')
                ->prices(['min'=> 1, 'max' => 9999])
                }}
            </div><!--col-->
        </div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('Description')
            ->class('col-md-2 form-control-label')
            ->for('description') }}

            <div class="col-md-3">
                {{ html()->text('description',$description)
                ->class('form-control')
                ->placeholder('description') }}
            </div><!--col-->
        </div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('View_number')
            ->class('col-md-2 form-control-label')
            ->for('view_number') }}

            <div class="col-md-3">
                {{ html()->text('view_number',$view_number)
                ->class('form-control')
                ->placeholder('view_number')
                ->required() }}
            </div><!--col-->
        </div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('status')
            ->class('col-md-2 form-control-label')
            ->for('status') }}

            <div class="col-md-3">
                {{ html()->text('status',$status)
                ->class('form-control')
                ->placeholder('status')
                ->required() }}
            </div><!--col-->
        </div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('Pickup_address')
            ->class('col-md-2 form-control-label')
            ->for('pickup_address')
            }}

            <div class="col-md-3">
                {{ html()->text('pickup_address',$pickup_address)
                ->class('form-control')
                ->placeholder('pickup_address')
                ->required() }}

            </div><!--col-->
        </div><!--form-group-->

            <div class="form-group row">
                {{ html()->label('Pickup_time')
                ->class('col-md-2 form-control-label')
                ->for('pickup_time')
                }}

                <div class="col-md-3">
                    {{ html()->text('pickup_time',$pickup_time)
                    ->class('form-control')
                    ->placeholder('pickup_time')
                    ->required() }}

                </div><!--col-->
                </div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('Created_at')
            ->class('col-md-2 form-control-label')
            ->for('created_at') }}

            <div class="col-md-3">
                {{ html()->text('created_at',$created_at)
                ->class('form-control')
                ->placeholder('created_at') }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Updated_at')
            ->class('col-md-2 form-control-label')
            ->for('updated_at') }}

            <div class="col-md-3">
                {{ html()->text('updated_at',$updated_at)
                ->class('form-control')
                ->placeholder('updated_at') }}
            </div><!--col-->
        </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label('Post_id')
                    ->class('col-md-2 form-control-label')
                    ->for('post_id') }}

                    <div class="col-md-3">
                        {{--{{ html()->text('post_id',$post_id)--}}
                        {{--->class('form-control')--}}
                        {{--->placeholder('post_id')
                        ->required }}--}}
                        <div class="file-field">
                            <div class="btn btn-primary btn-sm float-left">
                                <input type="file">
                            </div>
                        </div>
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
