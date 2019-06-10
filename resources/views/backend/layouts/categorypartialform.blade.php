@php
    if (isset($category)){
        $category_id = $category->category_id;
        $name = $category->name;
        $description = $category->description;
        $image_id = $category->image_id;
        $created_at = $category->created_at;
        $updated_at = $category->updated_at;
    }else{
        $category_id = null;
        $name = null;
        $description = null;
        $image_id = null;
        $created_at = null;
        $updated_at = null;
    }
@endphp
<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label('category_id')
                ->class('col-md-2 form-control-label')
                ->for('category_id') }}

            <div class="col-md-3">
                {{ html()->input('number','category_id', $category_id)
                    ->class('form-control')
                    ->placeholder('category_id')
                    ->attribute('min', 1)
                    ->required()
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
            {{ html()->label('Description')
                ->class('col-md-2 form-control-label')
                ->for('description') }}

            <div class="col-md-3">
                {{ html()->textarea('description',$description)
                    ->class('form-control')
                    ->placeholder('description')
                    ->attributes(['min'=> 1, 'max' => 9999])
                     }}
            </div><!--col-->
        </div><!--form-group-->
        <div class="form-group row">
            {{ html()->label('Image_id')
                ->class('col-md-2 form-control-label')
                ->for('image_id') }}

            <div class="col-md-3">
                {{ html()->input('file','image_id',$image_id)
                        ->class('form-control btn btn-primary btn-sm float-left')
                        ->placeholder('image')
                        ->required()
                    }}
               <!--  <div class="file-field"> // 
                    <div class="btn btn-primary btn-sm float-left">
                        <input type="file"> // you give it a name (name='image_id') or id
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
