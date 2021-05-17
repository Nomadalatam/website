<div class="col-xl-4 col-md-6 candidate-card">
    <div class="hover-effect-employee position-relative mb-5 border-hover-primary employee-border">
        <div class="employee-listing-details">
            <div class="d-flex employee-listing-description align-items-center justify-content-center flex-column">
                <div class="pl-0 mb-2 employee-avatar">
                    <img src="{{ $reportedEmployee->company->company_url }}"
                         class="img-responsive users-avatar-img employee-img mr-2">
                </div>
                <div class="mb-auto w-100 employee-data">
                    <div class="d-flex justify-content-center align-items-center w-100">
                        <div>
                            <label class="text-decoration-none text-color-gray">{{ $reportedEmployee->company->user->first_name }}</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <label>{{ __('messages.company.reported_by') }} :</label>
                        <label class="text-decoration-none text-color-gray">{{ $reportedEmployee->user->first_name }}</label>
                    </div>
                    <div class="text-center">
                        <label>{{ __('messages.company.reported_on') }} :</label>
                        <label class="text-decoration-none text-color-gray">{{ \Carbon\Carbon::parse($reportedEmployee->created_at)->formatLocalized('%d %b, %Y') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="employee-action-btn">
            <a title="{{ __('messages.job.notes') }}" class="btn btn-info action-btn view-note"
               data-id="{{$reportedEmployee->id}}" href="#">
                <i class="fas fa-eye"></i>
            </a>
            <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn delete-btn"
               data-id="{{$reportedEmployee->id}}" href="#">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>
