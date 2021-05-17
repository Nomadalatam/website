<?php

namespace App\Http\Controllers\Candidates;

use App;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CandidateUpdateGeneralInformationRequest;
use App\Http\Requests\CandidateUpdateOnlineProfileRequest;
use App\Http\Requests\CandidateUpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateCandidateProfileRequest;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateSkill;
use App\Models\JobApplication;
use App\Models\RequiredDegreeLevel;
use App\Models\User;
use App\Queries\CandidateAppliedJobDataTable;
use App\Queries\FavouriteCompanyDataTable;
use App\Queries\FavouriteJobDataTable;
use App\Repositories\Candidates\CandidateRepository;
use Auth;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Spatie\MediaLibrary\Models\Media;

class CandidateController extends AppBaseController
{
    /** @var  CandidateRepository */
    private $candidateRepository;

    public function __construct(CandidateRepository $candidateRepo)
    {
        $this->candidateRepository = $candidateRepo;
    }

    /**
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function editProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->phone = preparePhoneNumber($user->phone, $user->region_code);
        $data = $this->candidateRepository->prepareData();
        $countries = getCountries();
        $states = $cities = null;
        if (!empty($user->country_id)) {
            $states = getStates($user->country_id);
        }
        if (isset($user->state_id)) {
            $cities = getCities($user->state_id);
        }
        $candidateSkills = $user->candidateSkill()->pluck('skill_id')->toArray();
        $candidateLanguage = $user->candidateLanguage()->pluck('language_id')->toArray();
        $sectionName = ($request->section === null) ? 'general' : $request->section;
        $data['sectionName'] = $sectionName;

        if ($sectionName == 'resumes') {
            /** @var Candidate $candidate */
            $candidate = Candidate::findOrFail($user->candidate->id);

            $data['resumes'] = $candidate->getMedia('resumes');
        }

        if ($sectionName == 'career_informations' || $sectionName == 'cv_builder') {
            $data['candidateExperiences'] = CandidateExperience::where('candidate_id',
                $user->owner_id)->orderByDesc('id')->get();
            foreach ($data['candidateExperiences'] as $experience) {
                $experience->country = getCountryName($experience->country_id);
            }
            $data['candidateEducations'] = CandidateEducation::with('degreeLevel')->where('candidate_id',
                $user->owner_id)->orderByDesc('id')->get();
            foreach ($data['candidateEducations'] as $education) {
                $education->country = getCountryName($education->country_id);
            }
            $data['degreeLevels'] = RequiredDegreeLevel::pluck('name', 'id');
        }

        return view("candidate.profile.$sectionName",
            compact('user', 'data', 'countries', 'states', 'cities', 'candidateSkills', 'candidateLanguage'));
    }

    /**
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function showFavouriteJobs()
    {
        return view('candidate.favourite_jobs.index');
    }

    /**
     * @param  CandidateUpdateProfileRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function updateProfile(CandidateUpdateProfileRequest $request)
    {
        $this->candidateRepository->updateProfile($request->all());

        Flash::success('Candidate profile updated successfully.');

        return redirect(route('candidate.profile'));
    }

    /**
     * @param  CandidateUpdateGeneralInformationRequest  $request
     *
     * @throws \Throwable
     *
     * @return JsonResponse
     */
    public function updateGeneralInformation(CandidateUpdateGeneralInformationRequest $request)
    {
        $user = $this->candidateRepository->updateGeneralInformation($request->all());
        $user['candidateSkill'] = $user->candidateSkill()->pluck('name')->toArray();

        return $this->sendResponse($user, 'Candidate profile updated successfully.');
    }

    /**
     * @param  CandidateUpdateOnlineProfileRequest  $request
     *
     * @throws \Throwable
     *
     * @return JsonResponse
     */
    public function updateOnlineProfile(CandidateUpdateOnlineProfileRequest $request)
    {
        $user = $this->candidateRepository->updateGeneralInformation($request->all());
        $user['onlineProfileLayout'] = view('candidate.profile.career_informations.show_online_profile',
            compact('user'))->render();
        $user['editonlineProfileLayout'] = view('candidate.profile.career_informations.edit_online_profile',
            compact('user'))->render();

        return $this->sendResponse($user, 'Candidate profile updated successfully.');
    }
    
    /**
     * @throws \Throwable
     *
     * @return array|string
     */
    public function getCVTemplate()
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['candidateExperiences'] = CandidateExperience::where('candidate_id',
            $user->owner_id)->orderByDesc('id')->get();
        foreach ($data['candidateExperiences'] as $experience) {
            $experience->country = getCountryName($experience->country_id);
        }
        $data['candidateEducations'] = CandidateEducation::with('degreeLevel')->where('candidate_id',
            $user->owner_id)->orderByDesc('id')->get();
        foreach ($data['candidateEducations'] as $education) {
            $education->country = getCountryName($education->country_id);
        }

        return view('candidate.profile.cv_template')->with($data)->render();
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function uploadResume(Request $request)
    {
        $input = $request->all();

        $this->candidateRepository->uploadResume($input);

        return $this->sendSuccess('Resume updated successfully.');
    }

    /**
     * @param  int  $media
     *
     * @return Media
     */
    public function downloadResume($media)
    {
        /** @var Media $mediaItem */
        $mediaItem = Media::findOrFail($media);

        return $mediaItem;
    }

    /**
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function showFavouriteCompanies()
    {
        return view('candidate.favourite_companies.index');
    }

    /**
     * @return Factory|View
     */
    public function editJobAlert()
    {
        $data = $this->candidateRepository->getJobAlerts();

        return view('candidate.job_alert.edit')->with($data);
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function updateJobAlert(Request $request)
    {
        $this->candidateRepository->updateJobAlerts($request->all());
        Flash::success('Job Alert updated successfully.');

        return redirect(route('candidate.job.alert'));
    }

    /**
     * @param  ChangePasswordRequest  $request
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $input = $request->all();

        try {
            $user = $this->candidateRepository->changePassword($input);

            return $this->sendSuccess('Password updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified User.
     *
     * @return JsonResponse
     */
    public function editCandidateProfile()
    {
        $user = User::with('candidate')->where('id', '=', Auth::id())->first();

        return $this->sendResponse($user, 'Candidate retrieved successfully.');
    }

    /**
     * @param  UpdateCandidateProfileRequest  $request
     *
     * @return JsonResponse
     */
    public function profileUpdate(UpdateCandidateProfileRequest $request)
    {
        $input = $request->all();

        try {
            $employer = $this->candidateRepository->profileUpdate($input);

            return $this->sendResponse($employer, 'Candidate Profile updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     *
     * @return mixed
     */
    public function showCandidateAppliedJob()
    {
        return view('candidate.applied_job.index');
    }

    /**
     * @param  Media  $media
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function deletedResume(Media $media)
    {
        $media->delete();

        return $this->sendSuccess('Media deleted successfully.');
    }

    /**
     * @param  JobApplication  $jobApplication
     *
     * @return mixed
     */
    public function showAppliedJobs(JobApplication $jobApplication)
    {
        return $this->sendResponse($jobApplication, 'Retrieved successfully.');
    }
}
