<div class="modal fade" tabindex="-1" role="dialog" id="showModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.noticeboard.show_noticeboard') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="row details-page">
                    <div class="form-group col-sm-12">
                        {{ Form::label('name',__('messages.noticeboard.title').':') }}<br>
                        <span id="showTitle"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('description',__('messages.noticeboard.description').':') }}<br>
                        <span id="showDescription"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('is_active',__('messages.common.status').':') }}<br>
                        <span id="showIsActive"></span>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
