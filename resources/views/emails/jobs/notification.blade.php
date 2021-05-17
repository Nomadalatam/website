@component('mail::message')
    <style>
        .media {
            border-bottom: 1px solid #f9f9f9;
            padding-bottom: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .media-title {
            margin-top: 0;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 15px;
            color: #34395e;
        }

        .text-time {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .media-description {
            line-height: 24px;
        }

        .media-links {
            margin-top: 10px;
        }

        .media-body {
            margin-left: 10px;
        }
    </style>
    # Hi {{ $candidateName }},

    {!! 'Notification of all Job opportunities updated on '.now()->format('d-m-Y').'  in' !!} <a target="_blank"
                                                                                                 href="{{$url}}">{{ config('app.name') }}</a>

    @foreach($jobs as $key => $job)
        <li class="media">
            <img alt="image" class="mr-3 rounded-circle" width="70"
                 src="{{$job->company->company_url}}">
            <div class="media-body">
                <a class="media-title mb-1"
                   href="{{ route('front.job.details', $job->job_id) }}">{{ $job->job_title }}</a>
                <div class="text-time">{{ $job->created_at->diffForHumans() }}</div>
                <div class="media-description text-muted">{!! html_entity_decode($job->description) !!}</div>
                <div class="media-links">
                    <span>Expiry Date: {{ \Carbon\Carbon::parse($job->job_expiry_date)->format('d-m-Y') }}</span>
                </div>
            </div>
        </li>
        @if ($key + 1 != count($jobs))
            <hr>
        @endif
    @endforeach

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
