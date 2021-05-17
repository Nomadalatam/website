<div class="modal fade" tabindex="-1" role="dialog" id="showModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <th scope="col">{{ __('messages.company.reported_employer_detail') }}</th>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="row details-page">
                    <div class="form-group col-sm-12">
                        <div class="employee-listing-details">
                            <div class="d-flex employee-listing-description align-items-center justify-content-center flex-column">
                                <div class="pl-0 mb-2 employee-avatar">
                                    <span id="showImage"></span>
                                </div>
                                <div class="mb-auto w-100 employee-data">
                                    <div class="d-flex justify-content-center align-items-center w-100">
                                        <div>
                                            <label class="text-decoration-none text-color-gray" id="showName"></label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <span>{{ __('messages.company.reported_by') }} :</span>
                                        <label class="text-decoration-none text-color-gray" id="showReportedBy"></label>
                                    </div>
                                    <div class="text-center">
                                        <sapn>{{ __('messages.company.reported_on') }} :</sapn>
                                        <label class="text-decoration-none text-color-gray" id="showReportedOn"></label>
                                    </div>
                                    <div>
                                        <span>{{ __('messages.company.notes') }} :</span><br>
                                        <label id="showNote" class="reported-note"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
