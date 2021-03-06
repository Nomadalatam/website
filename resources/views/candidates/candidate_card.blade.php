<div class="col-xl-4 col-md-6 candidate-card">
    <div class="hover-effect-employee position-relative mb-5 border-hover-primary employee-border">
        <div class="employee-listing-details">
            <div class="d-flex employee-listing-description align-items-center justify-content-center flex-column">
                <div class="pl-0 mb-2 employee-avatar">
                    <img src="{{ $candidate['candidate_url'] }}"
                         class="img-responsive users-avatar-img employee-img mr-2">
                </div>
                <div class="mb-auto w-100 employee-data">
                    <div class="d-flex justify-content-center align-items-center w-100">
                        <div>
                            <a href="{{ route('candidates.index') }}/{{ $candidate['id'] }}"
                               class="employee-listing-title text-decoration-none">{{ $candidate['user']['first_name'] }}</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <label class="employee-label">{{ __('messages.common.email') }}</label>
                        <label class="text-decoration-none text-color-gray">{{ $candidate['user']['email'] }}</label>
                    </div>
                    <div class="text-center">
                        <span class="badge text-uppercase text-black available-badge"> {{ $candidate['immediate_available'] == 0 ? 'not Immediate Available':'immediate Available' }}</span>
                    </div>
                    <div class="text-center pt-1">
                        <label class="employee-label">{{ __('messages.candidate.candidate_skill') }}</label>
                        <label>
                            @foreach($candidate['user']['candidateSkill'] as $count => $skill)
                                @if($count < 1)
                                    <span class="font-size-13px post-badge badge-pill {{ $count }} badge-primary">{{ $skill->name }}</span>
                                @elseif($count == (count($candidate['user']['candidateSkill'])) - 1)
                                    <a href="#" data-toggle="dropdown" aria-expanded="false"
                                       class="font-size-13px  badge-pill badge-pill {{ $count }} badge-danger text-decoration-none">+{{  (count($candidate['user']['candidateSkill'])) - 1 }}</a>
                                    <div class="dropdown-menu more-info-menu background-badges background-badges-candidate">
                                        <a class="dropdown-item pt-0 more-dropdown">
                                            <div>
                                                @foreach($candidate['user']['candidateSkill'] as $count => $skill)
                                                    @if($count >= 1)
                                                        <br> <span
                                                                class="font-size-13px badge-pill {{ $count }} badge-{{ getBadgeColor($loop->index) }}">{{ $skill->name }}</span>
                                                        <br>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-0">
            <div class="text-center">
                <label class="custom-switch">
                    <input type="checkbox" name="Is Active"
                           class="custom-switch-input isActive"
                           data-id="{{ $candidate['id'] }}" {{ $candidate['user']['is_active']==0?'':'checked' }}>
                    <span class="custom-switch-indicator"></span>
                    <span class="employee-label ml-1">{{ __('messages.common.status') }}</span>
                </label>
            </div>
            <div class="text-center">
                <label class="custom-switch">
                    <input type="checkbox" name="Is Active" data-id="{{ $candidate['id'] }}"
                           class="custom-switch-input is-candidate-email-verified" {{ $candidate['user']['email_verified_at']!=null?'checked':'' }}>
                    <span class="custom-switch-indicator"></span>
                    <span class="employee-label ml-1">{{ __('messages.candidate.email_verified') }}</span>
                </label>
            </div>
            <div class="text-center">
                <a title="{{ __('messages.common.resend_verification_mail') }}"
                   class="btn btn-primary action-btn send-email-verification" data-id="{{ $candidate['id'] }}"
                   href="#">
                    <i class="fa fa-sync"></i>
                </a>
                <span class="employee-label ml-1">{{ __('messages.common.resend_verification_mail') }}</span>
            </div>
        </div>

        <div class="employee-action-btn">
            <a title="{{ __('messages.common.edit') }}"
               class="btn btn-warning action-btn edit-action-btn edit-btn"
               href="{{ route('candidates.index') }}/{{ $candidate['id'] }}/edit">
                <i class="fa fa-edit"></i>
            </a>
            <a title="{{ __('messages.common.delete') }}"
               class="btn btn-danger action-btn delete-action-btn delete-btn" data-id="{{ $candidate['id'] }}"
               href="#">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>
