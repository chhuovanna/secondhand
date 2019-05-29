@php
    if (isset($seller)){
        $seller_id = $seller->seller_id;
        $name = $seller->name;
        $address = $seller->address;
        $email = $seller->email;
        $phone = $seller->phone;
        $massage_account = $seller->massage_account;
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
        $massage_account = null;
        $type = null;
        $created_at = null;
        $updated_at = null;
        $image_id = null;
    }
@endphp
<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label('seller_id') //no need
                ->class('col-md-2 form-control-label')
                ->for('seller_id') }}

            <div class="col-md-3">
                {{ html()->input('number','seller_id', $seller_id)
                    ->class('form-control')
                    ->placeholder('seller_id')
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
            {{ html()->label('Address')
                ->class('col-md-2 form-control-label')
                ->for('address') }}

            <div class="col-md-3">
                {{ html()->input('text','address',$address)
                    ->class('form-control')
                    ->placeholder('address')
                    ->required()
                     }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Email')
                ->class('col-md-2 form-control-label')
                ->for('email') }}

            <div class="col-md-3">
                {{ html()->email('email',$email)
                    ->class('form-control')
                    ->placeholder('Email') }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Phone')
                ->class('col-md-2 form-control-label')
                ->for('phone') }}

            <div class="col-md-3">
                {{ html()->input('tel','phone',$phone)
                    ->class('form-control')
                    ->placeholder('phone')
                     ->required() }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Massage_account') //change to something understandable
                ->class('col-md-2 form-control-label')
                ->for('massage_account') }}

            <div class="col-md-3">
                {{ html()->text('massage_account',$massage_account)
                    ->class('form-control')
                    ->placeholder('message_account')
                     ->required() }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Type')
                ->class('col-md-2 form-control-label')
                ->for('type')
                 }}

            <div class="col-md-3">
                @php $options = ['Individual'=>'Individual','Shop'=>'Shop']; @endphp
                {{html()->select('type',$options)->class('form-control browser-default custom-select')}}

            </div><!--col-->
        </div><!--form-group-->
        
        <div class="form-group row">
            {{ html()->label('Image')
                ->class('col-md-2 form-control-label')
                ->for('image_id') }}

            <div class="col-md-3">
                

                {{ html()->input('file','image_id',$image_id)
                        ->class('form-control')
                        ->placeholder('image')
                        ->required()
                    }}
                <!-- <div class="file-field">
                    <div class="btn btn-primary btn-sm float-left">
                        <input type="file">
                    </div>
                </div> -->
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Created at')
                ->class('col-md-2 form-control-label')
                ->for('created_at') }}

            <div class="col-md-3">
                {{ html()->text('created_at',$created_at)
                    ->class('form-control')
                    ->placeholder('created at')
                    ->readonly() }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Updated at')
                ->class('col-md-2 form-control-label')
                ->for('updated_at') }}

            <div class="col-md-3">
                {{ html()->text('updated_at',$updated_at)
                    ->class('form-control')
                    ->placeholder('updated at')
                     ->readonly() }}
            </div><!--col-->
        </div><!--form-group-->
        
    </div><!--col-->
</div><!--row-->
