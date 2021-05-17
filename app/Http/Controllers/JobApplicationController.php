<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Queries\JobApplicationDataTable;
use App\Repositories\JobApplicationRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Spatie\MediaLibrary\Models\Media;
use Yajra\DataTables\DataTables;

class JobApplicationController extends AppBaseController
{
    /** @var  JobApplicationRepository */
    private $jobApplicationRepository;

    public function __construct(JobApplicationRepository $jobApplicationRepo)
    {
        $this->jobApplicationRepository = $jobApplicationRepo;
    }

    /**
     * Display a listing of the Industry.
     *
     * @param  int  $jobId
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index($jobId, Request $request)
    {
        $input['job_id'] = $jobId;
        $job = Job::with('city')->findOrFail($jobId);
        if ($request->ajax()) {
            return Datatables::of((new JobApplicationDataTable())->get($input))
                ->addColumn('hasResumeAvailable', function (JobApplication $jobApplication) {
                    $media = Media::find($jobApplication->resume_id);
                    if (! empty($media)) {
                        return empty($media);
                    }

                    $candidateResumeMedias = Media::where('model_id',
                        $jobApplication->candidate_id)->where('collection_name', 'resumes')->latest()->first();

                    return empty($candidateResumeMedias);
                })
                ->make(true);
        }
        $statusArray = JobApplication::STATUS;

        return view('employer.job_applications.index', compact('jobId', 'statusArray', 'job'));
    }


    /**
     * Remove the specified Job Application from storage.
     *
     * @param  JobApplication  $jobApplication
     *
     * @throws Exception
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy(JobApplication $jobApplication)
    {
        $this->jobApplicationRepository->delete($jobApplication->id);

        return $this->sendSuccess('Job Application deleted successfully.');
    }

    /**
     * @param  $id
     *
     * @param $status
     *
     * @return mixed
     */
    public function changeJobApplicationStatus($id, $status)
    {
        $jobApplication = JobApplication::with(['candidate.user', 'job'])->findOrFail($id);
        $candidateUserId = $jobApplication->candidate->user->id;
        $jobTitle = $jobApplication->job->job_title;
        if (! in_array($jobApplication->status, [JobApplication::REJECTED, JobApplication::COMPLETE])) {
            $jobApplication->update(['status' => $status]);

            $status == JobApplication::REJECTED ? NotificationSetting::whereKey(Notification::CANDIDATE_REJECTED_FOR_JOB)->first()->value == 1 ?
                addNotification([
                    Notification::CANDIDATE_REJECTED_FOR_JOB,
                    $candidateUserId,
                    Notification::CANDIDATE,
                    'Your application is Rejected for '.$jobTitle,
                ]) : false : false;

            $status == JobApplication::COMPLETE ? NotificationSetting::whereKey(Notification::CANDIDATE_SELECTED_FOR_JOB)->first()->value == 1 ?
                addNotification([
                    Notification::CANDIDATE_SELECTED_FOR_JOB,
                    $candidateUserId,
                    Notification::CANDIDATE,
                    'You are selected for '.$jobTitle,
                ]) : false : false;

            $status == JobApplication::SHORT_LIST ? NotificationSetting::whereKey(Notification::CANDIDATE_SHORTLISTED_FOR_JOB)->first()->value == 1 ?
                addNotification([
                    Notification::CANDIDATE_SHORTLISTED_FOR_JOB,
                    $candidateUserId,
                    Notification::CANDIDATE,
                    'Your application is Shortlisted for '.$jobTitle,
                ]) : false : false;

            return $this->sendSuccess('Status changed successfully.');
        }

        return $this->sendError(JobApplication::STATUS[$jobApplication->status].' job cannot be '.JobApplication::STATUS[$status]);
    }

    /**
     * @param  JobApplication  $jobApplication
     *
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function downloadMedia(JobApplication $jobApplication)
    {
        list($file, $headers) = $this->jobApplicationRepository->downloadMedia($jobApplication);

        return response($file, 200, $headers);
    }
}
