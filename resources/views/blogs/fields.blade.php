<div class="row">
    <div class="form-group col-sm-12">
        {{ Form::label('title',__('messages.post.title').':') }}<span
                class="text-danger">*</span>
        {{ Form::text('title', null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('blog_category_id', __('messages.post_category.post_category').':') }} <span class="text-danger">*</span>
        {{Form::select('blogCategories[]', $blogCategories, isset($post)?$selectedBlogCategories:null, ['class' => 'form-control','id'=>'blog_category_id','multiple'=>true,'required']) }}
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        <span id="validationErrorsBox" class="text-danger"></span>
        <div class="row">
            <div class="col-6 col-xl-3">
                {{ Form::label('image', __('messages.post.image').':') }}
                <label class="image__file-upload text-white"> {{ __('messages.common.choose') }}
                    {{ Form::file('image',['id'=>'image','class' => 'd-none']) }}
                </label>
            </div>
            <div class="col-6 col-xl-6 pl-0 mt-1">
                <img id='previewImage' class="thumbnail-preview w-25"
                     src="{{ empty($post->blog_image_url)?asset('assets/img/nomada-logo.png'):$post->blog_image_url  }}">
            </div>
        </div>
    </div>
    <div class="form-group col-sm-12">
        {{ Form::label('description',__('messages.post.description').':') }}<span
                class="text-danger">*</span>
        {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'description', 'rows' => '5']) }}
    </div>
</div>

<div class="text-left">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary']) }}
    <a href="{{ route('posts.index') }}" class="btn btn-secondary text-dark">{{__('messages.common.cancel')}}</a>
</div>
