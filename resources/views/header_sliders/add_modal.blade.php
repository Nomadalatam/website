<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="HeaderSlider">{{__('messages.header_slider.new_header_slider')}}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addNewForm','files'=>true]) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="row">
                            <div class="col-6">
                                {{ Form::label('header_slider', __('messages.image_slider.image').':') }}<span
                                        class="text-danger">*</span>
                                <span><i class="fas fa-question-circle ml-1"
                                         data-toggle="tooltip"
                                         data-placement="top"
                                         title="{{ __('messages.header_slider.image_title_text') }}"></i></span>
                                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                                    {{ Form::file('header_slider',['id'=>'headerSlider','class' => 'd-none']) }}
                                </label>
                            </div>
                            <div class="col-6 col-xl-6 pl-0 mt-1">
                                <img id='previewImage' class="img-thumbnail thumbnail-preview"
                                     src="{{ asset('assets/img/infyom-logo.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2 pt-2">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
