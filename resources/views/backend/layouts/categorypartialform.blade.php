@php
    if (isset($category)){
        $category_id = $category->category_ID;
        $name = $category->name;
        $description = $category->description;
        $image_id = $category->image_id;
    }else{
        $category_id = null;
        $name = null;
        $description = null;
        $image_id = null;
    }
@endphp
<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label('category_ID')
                ->class('col-md-1 form-control-label')
                ->for('category_id') }}

            <div class="col-md-3">
                {{ html()->input('number','category_id', $category_id)
                    ->class('form-control')
                    ->placeholder('category_id')
                    ->attribute('min', 1)
                    ->required()
                    ->autofocus() }}
            </div><!--col-->
        </div><!--form-group-->

        <div class="form-group row">
            {{ html()->label('Name')
                ->class('col-md-1 form-control-label')
                ->for('name') }}

            <div class="col-md-3">
                {{ html()->text('name',$name)
                    ->class('form-control')
                    ->placeholder('name')
                    ->required() }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Description')
                ->class('col-md-1 form-control-label')
                ->for('description') }}

            <div class="col-md-3">
                {{ html()->input('number','description',$description)
                    ->class('form-control')
                    ->placeholder('description')
                    ->attributes(['min'=> 1, 'max' => 9999])
                     }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Image_id')
                ->class('col-md-1 form-control-label')
                ->for('image_id') }}

            <div class="col-md-3">
                {{ html()->text('image_id',$image_id)
                    ->class('form-control')
                    ->placeholder('image_id') }}
            </div><!--col-->
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->
