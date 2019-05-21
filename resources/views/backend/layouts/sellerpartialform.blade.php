@php
    if (isset($seller)){
        $seller_id = $seller->seller_ID;
        $name = $seller->name;
        $address = $seller->address;
        $email = $seller->email;
        $phone = $seller->phone;
        $massageaccount = $seller->massageaccount;
        $type = $seller->type;
        $created_at = $seller->created_at;
        $updated_at = $seller->updated_at;
        $image_id = $seller->image_id;
    }else{
        $seller_id = null;
        $name = null;
        $address = null;
        $email = null;
        $phone = null;
        $instant_massage_account = null;
        $type = null;
        $created_at = null;
        $updated_at = null;
        $image_id = null;
    }
@endphp
<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label('seller_ID') //no need
                ->class('col-md-2 form-control-label')
                ->for('seller_id') }}

            <div class="col-md-3">
                {{ html()->input('number','seller_id', $seller_id)
                    ->class('form-control')
                    ->placeholder('seller_id')
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
            {{ html()->label('Address') //change to something understandable
                ->class('col-md-2 form-control-label')
                ->for('address') }}

            <div class="col-md-3">
                {{ html()->input('number','address',$address)
                    ->class('form-control')
                    ->placeholder('address')
                    ->attributes(['min'=> 1, 'max' => 9999])
                     }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Email')
                ->class('col-md-2 form-control-label')
                ->for('email') }}

            <div class="col-md-3">
                {{ html()->text('email',$email)
                    ->class('form-control')
                    ->placeholder('email') }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Phone')
                ->class('col-md-2 form-control-label')
                ->for('phone') }}

            <div class="col-md-3">
                {{ html()->text('phone',$phone)
                    ->class('form-control')
                    ->placeholder('phone')
                     ->required() }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Massage account') //change to something understandable
                ->class('col-md-2 form-control-label')
                ->for('massage account') }}

            <div class="col-md-3">
                {{ html()->text('massage account',$instant_massage_account)
                    ->class('form-control')
                    ->placeholder('massage account')
                     ->required() }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Type')
                ->class('col-md-2 form-control-label')
                ->for('type')
                 }}

            <div class="col-md-3">
                {{--{{ html()->text('type',$type) //select options: [individual , shop]--}}
                    {{--->class('form-control')--}}
                    {{--->placeholder('type')--}}
                    {{--->required() }}--}}
                <select class="browser-default custom-select">
                    <option value="individual">individual</option>
                    <option value="shop">shop</option>

                </select>
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
