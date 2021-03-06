<div id="editModal" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brandingSlider">{{__('messages.branding_slider.edit_branding_slider')}}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id' => 'editForm', 'files' => true]) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                {{ Form::hidden('brandingSliderId', null, ['id' => 'brandingSliderId']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                {{ Form::label('title', __('messages.candidate_profile.title').':') }}
                                <span class="text-danger">*</span>
                                {{ Form::text('title', null, ['class' => 'form-control', 'id' => 'editTitle', 'required']) }}
                            </div>
                            <div class="col-6">
                                {{ Form::label('branding_slider', __('messages.image_slider.image').':') }}
                                <span class="text-danger">*</span>
                                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                                    {{ Form::file('branding_slider', ['id' => 'editBrandingSlider', 'class' => 'd-none']) }}
                                </label>
                            </div>
                            <div class="col-6 col-xl-6 pl-0 mt-1">
                                <img id='editPreviewImage' class="img-thumbnail thumbnail-preview"
                                     src="{{ asset('assets/img/infyom-logo.png') }}"/>
                            </div>
                        </div>
                        <a href="#" target="_blank" id="brandingSliderUrl"></a>
                    </div>
                </div>
                <div class="text-right mt-2 pt-2">
                    {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'btnEditSave', 'data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1" data-dismiss="modal">
                        {{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
