<?php

namespace App\Repositories;

use App\Mail\JobNotification;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use Arr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class JobNotificationRepository
 */
class JobNotificationRepository
{
    /**
     * @return mixed
     */
    public function getJobNotificationData()
    {
        $data['candidates'] = Candidate::with('user')->whereHas('user', function (Builder $q) {
            $q->where('is_active', true);
        })->get()->pluck('user.full_name', 'id');

        $now = Carbon::now()->toDateString();
        $data['jobs'] = Job::whereDate('job_expiry_date', '>=', $now)->where('status', '1')->orderBy('created_at',
            'desc')->get();

        $data['companies'] = Company::with('user')->whereHas('user', function (Builder $q) {
            $q->where('is_active', true);
        })->get()->pluck('user.full_name', 'id');

        return $data;
    }


    public function sendJobNotification($input)
    {
        $candidateIds = Arr::only($input, 'candidate_id')['candidate_id'];
        $jobIds = Arr::only($input, 'job_id')['job_id'];

        $candidates = Candidate::with('user')->whereIn('id', $candidateIds)->get();
        $jobs = Job::whereIn('id', $jobIds)->get();


        try {
            DB::beginTransaction();
            foreach ($candidates as $candidate) {
                Mail::to($candidate->user->email)->send(new JobNotification($jobs, $candidate->user->full_name));
            }

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
