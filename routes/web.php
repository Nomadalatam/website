<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('web.home.home');
})->name('web.home');

Auth::routes(['verify' => true, 'register' => false]);
Route::get('admin/login', 'Auth\LoginController@showAdminLoginForm')->name('admin.login');
Route::post('users/login', 'Auth\Front\LoginController@login')->name('front.login');
Route::get('users/employee-login', 'Auth\Front\LoginController@employeeLogin')->name('front.employee.login');
Route::get('users/candidate-login', 'Auth\Front\LoginController@candidateLogin')->name('front.candidate.login');
Route::get('pricing', function () {
    return view('pricing.index');
});

Route::any('subscription-update', 'SubscriptionController@updateSubscription')->name('subscription-update');

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'Web\WebController@index')->name('front');

Route::post('news-letter', 'Web\WebController@newsLetter')->name('news-letter.create');

Route::group(['middleware' => ['auth', 'role:Admin', 'xss', 'verified.user'], 'prefix' => 'admin'], function () {

    // dashboard route
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

    // Read notification
    Route::post('/notification/{notification}/read',
        'NotificationController@readNotification')->name('read-notification');
    Route::post('/read-all-notification', 'NotificationController@readAllNotification')->name('read-all-notification');

    // subscribers route
    Route::get('subscribers', 'SubscriberController@index')->name('subscribers.index');
    Route::delete('subscribers/{newsLetter}', 'SubscriberController@destroy')->name('subscribers.destroy');

    // Job Category routes
    Route::get('job-categories', 'JobCategoryController@index')->name('job-categories.index');
    Route::post('job-categories', 'JobCategoryController@store')->name('job-categories.store');
    Route::get('job-categories/{jobCategory}/edit', 'JobCategoryController@edit')->name('job-categories.edit');
    Route::get('job-categories/{jobCategory}', 'JobCategoryController@show')->name('job-categories.show');
    Route::put('job-categories/{jobCategory}', 'JobCategoryController@update')->name('job-categories.update');
    Route::delete('job-categories/{jobCategory}', 'JobCategoryController@destroy')->name('job-categories.destroy');
    Route::post('job-categories/{jobCategory}/change-status', 'JobCategoryController@changeStatus');

    // settings routes
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::post('settings', 'SettingController@update')->name('settings.update');

    // Privacy Policy routes
    Route::get('privacy-policy', 'PrivacyPolicyController@index')->name('privacy.policy.index');
    Route::post('privacy-policy', 'PrivacyPolicyController@update')->name('privacy.policy.update');

    // Company Size
    Route::get('company-sizes', 'CompanySizeController@index')->name('companySize.index');
    Route::post('company-sizes', 'CompanySizeController@store')->name('companySize.store');
    Route::get('company-sizes/{companySize}/edit', 'CompanySizeController@edit')->name('companySize.edit');
    Route::put('company-sizes/{companySize}', 'CompanySizeController@update')->name('companySize.update');
    Route::delete('company-sizes/{companySize}', 'CompanySizeController@destroy')->name('companySize.destroy');


    //Skills
    Route::get('skills', 'SkillController@index')->name('skills.index');
    Route::post('skills', 'SkillController@store')->name('skills.store');
    Route::get('skills/{skill}', 'SkillController@show')->name('skills.show');
    Route::get('skills/{skill}/edit', 'SkillController@edit')->name('skills.edit');
    Route::put('skills/{skill}', 'SkillController@update')->name('skills.update');
    Route::delete('skills/{skill}', 'SkillController@destroy')->name('skills.destroy');


    // Marital Status
    Route::get('marital-status', 'MaritalStatusController@index')->name('maritalStatus.index');
    Route::post('marital-status', 'MaritalStatusController@store')->name('maritalStatus.store');
    Route::get('marital-status/{maritalStatus}', 'MaritalStatusController@show')->name('maritalStatus.show');
    Route::get('marital-status/{maritalStatus}/edit',
        'MaritalStatusController@edit')->name('maritalStatus.edit');
    Route::put('marital-status/{maritalStatus}',
        'MaritalStatusController@update')->name('maritalStatus.update');
    Route::delete('marital-status/{maritalStatus}',
        'MaritalStatusController@destroy')->name('maritalStatus.destroy');

    // Salary Period
    Route::get('salary-periods', 'SalaryPeriodController@index')->name('salaryPeriod.index');
    Route::post('salary-periods', 'SalaryPeriodController@store')->name('salaryPeriod.store');
    Route::get('salary-periods/{salaryPeriod}', 'SalaryPeriodController@show')->name('salaryPeriod.show');
    Route::get('salary-periods/{salaryPeriod}/edit', 'SalaryPeriodController@edit')->name('salaryPeriod.edit');
    Route::put('salary-periods/{salaryPeriod}', 'SalaryPeriodController@update')->name('salaryPeriod.update');
    Route::delete('salary-periods/{salaryPeriod}', 'SalaryPeriodController@destroy')->name('salaryPeriod.destroy');

    // Job Shift
    Route::get('job-shifts', 'JobShiftController@index')->name('jobShift.index');
    Route::post('job-shifts', 'JobShiftController@store')->name('jobShift.store');
    Route::get('job-shifts/{jobShift}', 'JobShiftController@show')->name('jobShift.show');
    Route::get('job-shifts/{jobShift}/edit', 'JobShiftController@edit')->name('jobShift.edit');
    Route::put('job-shifts/{jobShift}', 'JobShiftController@update')->name('jobShift.update');
    Route::delete('job-shifts/{jobShift}', 'JobShiftController@destroy')->name('jobShift.destroy');

    // Required Degree Level
    Route::get('required-degree-level', 'RequiredDegreeLevelController@index')->name('requiredDegreeLevel.index');
    Route::post('required-degree-level', 'RequiredDegreeLevelController@store')->name('requiredDegreeLevel.store');
    Route::get('required-degree-level/{requiredDegreeLevel}',
        'RequiredDegreeLevelController@show')->name('requiredDegreeLevel.show');
    Route::get('required-degree-level/{requiredDegreeLevel}/edit',
        'RequiredDegreeLevelController@edit')->name('requiredDegreeLevel.edit');
    Route::put('required-degree-level/{requiredDegreeLevel}',
        'RequiredDegreeLevelController@update')->name('requiredDegreeLevel.update');
    Route::delete('required-degree-level/{requiredDegreeLevel}',
        'RequiredDegreeLevelController@destroy')->name('requiredDegreeLevel.destroy');

    // All Candidate Resumes
    Route::get('resumes', 'CandidateController@resumes')->name('resumes.index');
    Route::get('/media/{media?}', 'CandidateController@downloadResume')->name('download.all-resume');
    Route::delete('delete-resumes/{media?}',
        'CandidateController@deleteResume')->name('delete.resume');

    // Industries
    Route::get('industries', 'IndustryController@index')->name('industry.index');
    Route::post('industries', 'IndustryController@store')->name('industry.store');
    Route::get('industries/{industry}', 'IndustryController@show')->name('industry.show');
    Route::get('industries/{industry}/edit', 'IndustryController@edit')->name('industry.edit');
    Route::put('industries/{industry}', 'IndustryController@update')->name('industry.update');
    Route::delete('industries/{industry}', 'IndustryController@destroy')->name('industry.destroy');

    // Job Tags
    Route::get('job-tags', 'TagController@index')->name('jobTag.index');
    Route::post('job-tags', 'TagController@store')->name('jobTag.store');
    Route::get('job-tags/{tag}', 'TagController@show')->name('jobTag.show');
    Route::get('job-tags/{tag}/edit', 'TagController@edit')->name('jobTag.edit');
    Route::put('job-tags/{tag}', 'TagController@update')->name('jobTag.update');
    Route::delete('job-tags/{tag}', 'TagController@destroy')->name('jobTag.destroy');

    // Job Types
    Route::get('job-types', 'JobTypeController@index')->name('jobType.index');
    Route::post('job-types', 'JobTypeController@store')->name('jobType.store');
    Route::get('job-types/{jobType}', 'JobTypeController@show')->name('jobType.show');
    Route::get('job-types/{jobType}/edit', 'JobTypeController@edit')->name('jobType.edit');
    Route::put('job-types/{jobType}', 'JobTypeController@update')->name('jobType.update');
    Route::delete('job-types/{jobType}', 'JobTypeController@destroy')->name('jobType.destroy');

    // OwnerShip Type
    Route::get('ownership-types', 'OwnerShipTypeController@index')->name('ownerShipType.index');
    Route::post('ownership-types', 'OwnerShipTypeController@store')->name('ownerShipType.store');
    Route::get('ownership-types/{ownerShipType}/edit', 'OwnerShipTypeController@edit')->name('ownerShipType.edit');
    Route::get('ownership-types/{ownerShipType}', 'OwnerShipTypeController@show')->name('ownership-types.show');
    Route::put('ownership-types/{ownerShipType}', 'OwnerShipTypeController@update')->name('ownerShipType.update');
    Route::delete('ownership-types/{ownerShipType}', 'OwnerShipTypeController@destroy')->name('ownerShipType.destroy');

    // Industries
    Route::get('industries', 'IndustryController@index')->name('industry.index');
    Route::post('industries', 'IndustryController@store')->name('industry.store');
    Route::get('industries/{industry}', 'IndustryController@show')->name('industry.show');
    Route::get('industries/{industry}/edit', 'IndustryController@edit')->name('industry.edit');
    Route::put('industries/{industry}', 'IndustryController@update')->name('industry.update');
    Route::delete('industries/{industry}', 'IndustryController@destroy')->name('industry.destroy');

    // Companies
    Route::get('companies', 'CompanyController@index')->name('company.index');
    Route::get('companies/create', 'CompanyController@create')->name('company.create');
    Route::post('companies', 'CompanyController@store')->name('company.store');
    Route::get('companies/{company}', 'CompanyController@show')->name('company.show');
    Route::get('companies/{company}/edit', 'CompanyController@edit')->name('company.edit');
    Route::put('companies/{company}', 'CompanyController@update')->name('company.update');
    Route::delete('companies/{company}', 'CompanyController@destroy')->name('company.destroy');
    Route::post('companies/{company}/change-is-active', 'CompanyController@changeIsActive');
    Route::post('companies/{company}/verify-email', 'CompanyController@changeIsEmailVerified');
    Route::post('companies/{company}/resend-email-verification', 'CompanyController@resendEmailVerification');
    Route::post('companies/{company}/mark-as-featured',
        'CompanyController@markAsFeatured')->name('mark-as-featured');
    Route::post('companies/{company}/mark-as-unfeatured',
        'CompanyController@markAsUnFeatured')->name('mark-as-featured');


    // Language routes
    Route::get('languages', 'LanguageController@index')->name('languages.index');
    Route::post('languages', 'LanguageController@store')->name('languages.store');
    Route::get('languages/{language}/edit', 'LanguageController@edit')->name('languages.edit');
    Route::get('languages/{language}', 'LanguageController@show')->name('languages.show');
    Route::put('languages/{language}', 'LanguageController@update')->name('languages.update');
    Route::delete('languages/{language}', 'LanguageController@destroy')->name('languages.destroy');
    Route::post('languages/{language}/{param}/change-status', 'LanguageController@changeStatus');


    // Functional Area
    Route::get('functional-area', 'FunctionalAreaController@index')->name('functionalArea.index');
    Route::post('functional-area', 'FunctionalAreaController@store')->name('functionalArea.store');
    Route::get('functional-area/{functionalArea}/edit',
        'FunctionalAreaController@edit')->name('functionalArea.edit');
    Route::put('functional-area/{functionalArea}',
        'FunctionalAreaController@update')->name('functionalArea.update');
    Route::delete('functional-area/{functionalArea}',
        'FunctionalAreaController@destroy')->name('functionalArea.destroy');


    // Career Level
    Route::get('career-levels', 'CareerLevelController@index')->name('careerLevel.index');
    Route::post('career-levels', 'CareerLevelController@store')->name('careerLevel.store');
    Route::get('career-levels/{careerLevel}/edit',
        'CareerLevelController@edit')->name('careerLevel.edit');
    Route::put('career-levels/{careerLevel}',
        'CareerLevelController@update')->name('careerLevel.update');
    Route::delete('career-levels/{careerLevel}',
        'CareerLevelController@destroy')->name('careerLevel.destroy');

    Route::get('profile', 'UserController@editProfile');
    Route::post('change-password', 'UserController@changePassword');
    Route::post('profile-update', 'UserController@profileUpdate');

    // Salary Currency
    Route::get('salary-currencies', 'SalaryCurrencyController@index')->name('salaryCurrency.index');

    // jobs route
    Route::get('jobs', 'JobController@getJobs')->name('admin.jobs.index');
    Route::get('jobs/create', 'JobController@createJob')->name('admin.job.create');
    Route::post('jobs', 'JobController@storeJob')->name('admin.job.store');
    Route::get('jobs/{job}/edit', 'JobController@editJob')->name('admin.job.edit');
    Route::put('jobs/{job}', 'JobController@updateJob')->name('admin.job.update');
    Route::get('jobs/{job}', 'JobController@showJobs')->name('admin.jobs.show');
    Route::delete('jobs/{job}', 'JobController@delete')->name('admin.jobs.destroy');
    Route::post('jobs/{job}/change-is-suspend', 'JobController@changeIsSuspended');
    Route::post('jobs/{job}/make-job-featured', 'JobController@makeFeatured');
    Route::post('jobs/{job}/make-job-unfeatured', 'JobController@makeUnFeatured');

    // candidate routes
    Route::get('candidates', 'CandidateController@index')->name('candidates.index');
    Route::get('candidates/create', 'CandidateController@create')->name('candidates.create');
    Route::post('candidates', 'CandidateController@store')->name('candidates.store');
    Route::get('candidates/{candidate}/edit', 'CandidateController@edit')->name('candidates.edit');
    Route::get('candidates/{candidate}', 'CandidateController@show')->name('candidates.show');
    Route::put('candidates/{candidate}', 'CandidateController@update')->name('candidates.update');
    Route::delete('candidates/{candidate}', 'CandidateController@destroy')->name('candidates.destroy');
    Route::post('candidates/{id}/change-status', 'CandidateController@changeStatus');
    Route::post('candidates/{candidate}/verify-email',
        'CandidateController@changeIsEmailVerified');
    Route::post('candidates/{candidate}/resend-email-verification', 'CandidateController@resendEmailVerification');

    //Testimonials  routes
    Route::get('testimonials', 'TestimonialsController@index')->name('testimonials.index');
    Route::post('testimonials', 'TestimonialsController@store')->name('testimonials.store');
    Route::get('testimonials/{testimonial}/edit', 'TestimonialsController@edit')->name('testimonials.edit');
    Route::get('testimonials/{testimonial}', 'TestimonialsController@show')->name('testimonials.show');
    Route::post('testimonials/{testimonial}/update', 'TestimonialsController@update')->name('testimonials.update');
    Route::delete('testimonials/{testimonial}', 'TestimonialsController@destroy')->name('testimonials.destroy');
    Route::get('/download-image/{testimonial}', 'TestimonialsController@downloadImage')->name('download.image');

    //Front Image Slider Routes
    Route::get('image-sliders', 'ImageSliderController@index')->name('image-sliders.index');
    Route::post('image-sliders', 'ImageSliderController@store')->name('image-sliders.store');
    Route::get('image-sliders/{image_slider}/edit', 'ImageSliderController@edit')->name('image-sliders.edit');
    Route::post('image-sliders/{image_slider}/update', 'ImageSliderController@update')->name('image-sliders.update');
    Route::delete('image-sliders/{image_slider}', 'ImageSliderController@destroy')->name('image-sliders.destroy');
    Route::post('image-sliders/{image_slider}/change-is-active', 'ImageSliderController@changeIsActive');
    Route::post('image-sliders/change-full-slider',
        'ImageSliderController@changeFullSlider')->name('image-sliders.change-full-slider');
    Route::post('image-sliders/change-slider-active',
        'ImageSliderController@changeSliderActive')->name('image-sliders.change-slider-active');

    //Front Header Slider Routes
    Route::get('header-sliders', 'HeaderSliderController@index')->name('header.sliders.index');
    Route::post('header-sliders', 'HeaderSliderController@store')->name('header.sliders.store');
    Route::get('header-sliders/{header_slider}/edit', 'HeaderSliderController@edit')->name('header.sliders.edit');
    Route::post('header-sliders/{header_slider}/update',
        'HeaderSliderController@update')->name('header.sliders.update');
    Route::delete('header-sliders/{header_slider}', 'HeaderSliderController@destroy')->name('header.sliders.destroy');
    Route::post('header-sliders/{header_slider}/change-is-active', 'HeaderSliderController@changeIsActive');
    Route::post('header-sliders/change-search-disable',
        'HeaderSliderController@changeSearchDisable')->name('header.sliders.change-search-disable');

    //Front Branding Slider Routes
    Route::get('branding-sliders', 'BrandingSliderController@index')->name('branding.sliders.index');
    Route::post('branding-sliders', 'BrandingSliderController@store')->name('branding.sliders.store');
    Route::get('branding-sliders/{brandingSlider}/edit',
        'BrandingSliderController@edit')->name('branding.sliders.edit');
    Route::post('branding-sliders/{brandingSlider}/update',
        'BrandingSliderController@update')->name('branding.sliders.update');
    Route::delete('branding-sliders/{brandingSlider}',
        'BrandingSliderController@destroy')->name('branding.sliders.destroy');
    Route::post('branding-sliders/{brandingSlider}/change-is-active', 'BrandingSliderController@changeIsActive');

    // Noticeboard Routes
    Route::get('noticeboards', 'NoticeboardController@index')->name('noticeboards.index');
    Route::post('noticeboards', 'NoticeboardController@store')->name('noticeboards.store');
    Route::get('noticeboards/{noticeboard}', 'NoticeboardController@show')->name('noticeboards.show');
    Route::get('noticeboards/{noticeboard}/edit', 'NoticeboardController@edit')->name('noticeboards.edit');
    Route::put('noticeboards/{noticeboard}', 'NoticeboardController@update')->name('noticeboards.update');
    Route::delete('noticeboards/{noticeboard}', 'NoticeboardController@destroy')->name('noticeboards.destroy');
    Route::post('noticeboards/{id}/change-status', 'NoticeboardController@changeStatus')->name('noticeboard.status');

    // FAQ routes
    Route::get('faqs', 'FAQController@index')->name('faqs.index');
    Route::post('faqs', 'FAQController@store')->name('faqs.store');
    Route::get('faqs/{faq}', 'FAQController@show')->name('faqs.show');
    Route::get('faqs/{faq}/edit', 'FAQController@edit')->name('faqs.edit');
    Route::put('faqs/{faq}', 'FAQController@update')->name('faqs.update');
    Route::delete('faqs/{faq}', 'FAQController@destroy')->name('faqs.destroy');

    // inquires listing route
    Route::get('inquires', 'InquiryController@index')->name('inquires.index');
    Route::get('inquires/{inquiry}', 'InquiryController@show')->name('inquires.show');
    Route::delete('inquires/{inquiry}', 'InquiryController@destroy')->name('inquires.destroy');

    // Post Category Routes
    Route::get('post-categories', 'PostCategoryController@index')->name('post-categories.index');
    Route::post('post-categories', 'PostCategoryController@store')->name('post-categories.store');
    Route::get('post-categories/{postCategory}', 'PostCategoryController@show')->name('post-categories.show');
    Route::get('post-categories/{postCategory}/edit', 'PostCategoryController@edit')->name('post-categories.edit');
    Route::put('post-categories/{postCategory}', 'PostCategoryController@update')->name('post-categories.update');
    Route::delete('post-categories/{postCategory}', 'PostCategoryController@destroy')->name('post-categories.destroy');

    // Post Routes
    Route::get('posts', 'PostController@index')->name('posts.index');
    Route::get('posts/create', 'PostController@create')->name('posts.create');
    Route::post('posts', 'PostController@store')->name('posts.store');
    Route::get('posts/{post}', 'PostController@show')->name('posts.show');
    Route::get('posts/{post}/edit', 'PostController@edit')->name('posts.edit');
    Route::put('posts/{post}', 'PostController@update')->name('posts.update');
    Route::delete('posts/{post}', 'PostController@destroy')->name('posts.destroy');

    // Reported Job Listing
    Route::get('reported-jobs', 'JobController@showReportedJobs')->name('reported.jobs');
    Route::get('reported-jobs/{reportedJob}', 'JobController@showReportedJobNote')->name('reported.jobs.show');
    Route::delete('reported-jobs/{reportedJob}', 'JobController@deleteReportedJobs')->name('delete.reported.jobs');

    //Reported company
    Route::get('reported-company', 'CompanyController@showReportedCompanies')->name('reported.companies');
    Route::get('reported-company/{reportedToCompany}',
        'CompanyController@showReportedCompanyNote')->name('reported.companies.show');
    Route::delete('reported-company/{reportedToCompany}',
        'CompanyController@deleteReportedCompany')->name('delete.reported.company');

    //Reported candidate
    Route::get('reported-candidate', 'CandidateController@showReportedCandidates')->name('reported.candidates');
    Route::get('reported-candidate/{reportedToCandidate}',
        'CandidateController@showReportedCandiateNote')->name('reported.candidates.show');
    Route::delete('reported-candidate/{reportedToCandidate}',
        'CandidateController@deleteReportedCandidate')->name('delete.reported.candidate');

    // plans routes
    Route::get('plans', 'PlanController@index')->name('plans.index');
    Route::post('plans', 'PlanController@store')->name('plans.store');
    Route::get('plans/{plan}/edit', 'PlanController@edit')->name('plans.edit');
    Route::put('plans/{plan}', 'PlanController@update')->name('plans.update');
    Route::delete('plans/{plan}', 'PlanController@destroy')->name('plans.destroy');
    Route::post('plans/{plan}/change-trial-plan', 'PlanController@changeTrialPlan')->name('plans.change-trial-plan');

    // transactions route
    Route::get('transactions', 'TransactionController@index')->name('transactions.index');
    Route::get('invoices/{invoiceId}', 'TransactionController@getTransactionInvoice');

    // Front setting routes
    Route::get('front-settings', 'FrontSettingsController@index')->name('front.settings.index');
    Route::post('front-settings', 'FrontSettingsController@update')->name('front.settings.update');

    // Notification setting routes
    Route::get('notification-settings', 'NotificationSettingsController@index')->name('notification.settings.index');
    Route::post('notification-settings', 'NotificationSettingsController@update')->name('notification.settings.update');

    //Candidate Excel
    Route::get('candidates-export-excel', 'CandidateController@candidateExportExcel')->name('candidates.export.excel');

    // Country routes
    Route::get('countries', 'CountryController@index')->name('countries.index');
    Route::post('countries', 'CountryController@store')->name('countries.store');
    Route::get('countries/{country}/edit', 'CountryController@edit')->name('countries.edit');
    Route::put('countries/{country}', 'CountryController@update')->name('countries.update');
    Route::delete('countries/{country}', 'CountryController@destroy')->name('countries.destroy');

    // State routes
    Route::get('states', 'StateController@index')->name('states.index');
    Route::post('states', 'StateController@store')->name('states.store');
    Route::get('states/{state}/edit', 'StateController@edit')->name('states.edit');
    Route::put('states/{state}', 'StateController@update')->name('states.update');
    Route::delete('states/{state}', 'StateController@destroy')->name('states.destroy');

    // City routes
    Route::get('cities', 'CityController@index')->name('cities.index');
    Route::post('cities', 'CityController@store')->name('cities.store');
    Route::get('cities/{city}/edit', 'CityController@edit')->name('cities.edit');
    Route::put('cities/{city}', 'CityController@update')->name('cities.update');
    Route::delete('cities/{city}', 'CityController@destroy')->name('cities.destroy');

    Route::get('job-notifications', 'JobNotificationController@index')->name('job-notification.index');
    Route::post('job-notifications', 'JobNotificationController@store')->name('job-notification.store');
    Route::get('employer-jobs/{id}', 'JobNotificationController@getEmployerJobs')->name('get-employer.jobs');

    Route::get('translation-manager', 'TranslationManagerController@index')->name('translation-manager.index');
    Route::post('translation-manager', 'TranslationManagerController@store')->name('translation-manager.store');
    Route::post('translation-manager/update',
        'TranslationManagerController@update')->name('translation-manager.update');
});

Route::group(['middleware' => ['auth', 'role:Admin|Employer|Candidate', 'xss', 'verified.user']], function () {
    Route::get('states-list', 'JobController@getStates')->name('states-list');
    Route::get('cities-list', 'JobController@getCities')->name('cities-list');
    Route::post('update-language', 'UserController@updateLanguage');

    // job stripe payment
    Route::post('job-stripe-charge', 'FeaturedJobSubscriptionController@createSession');
    Route::get('job-payment-success', 'FeaturedJobSubscriptionController@paymentSuccess')->name('job-payment-success');
    Route::get('job-failed-payment',
        'FeaturedJobSubscriptionController@handleFailedPayment')->name('job-failed-payment');

    // companie stripe payment
    Route::post('company-stripe-charge', 'FeaturedCompanySubscriptionController@createSession');
    Route::get('company-payment-success',
        'FeaturedCompanySubscriptionController@paymentSuccess')->name('company-payment-success');
    Route::get('company-failed-payment',
        'FeaturedCompanySubscriptionController@handleFailedPayment')->name('company-failed-payment');
});

Route::group(['middleware' => ['auth', 'role:Employer', 'xss', 'verified.user'], 'prefix' => 'employer'], function () {
// TODO:: need to change this
    Route::get('/employer', function () {
        return view('employer.layouts.app');
    });

    Route::get('dashboard', 'DashboardController@employerDashboard')->name('employer.dashboard');
    Route::get('employer-dashboard-chart',
        'DashboardController@employerDashboardChart')->name('employer.dashboard.chart');
    Route::get('employer-job-data', 'DashboardController@getJobData')->name('employer.job.data');

    // Read notification
    Route::post('/notification/{notification}/read',
        'NotificationController@readNotification')->name('read-notification');
    Route::post('/read-all-notification', 'NotificationController@readAllNotification')->name('read-all-notification');

    //model profile and password
    Route::get('employer-profile', 'EmployerController@editProfile');
    Route::post('employer-change-password', 'EmployerController@changePassword');
    Route::post('employer-profile-update', 'EmployerController@profileUpdate');

    // Job Applications
    Route::get('jobs/{jobId}/applications', 'JobApplicationController@index')->name('job-applications');
    Route::get('job-applications/{id}/status/{status}', 'JobApplicationController@changeJobApplicationStatus');
    Route::delete('job-applications/{jobApplication}',
        'JobApplicationController@destroy')->name('job.application.destroy');
    Route::get('resume-download/{jobApplication}', 'JobApplicationController@downloadMedia');

    // Jobs
    Route::get('jobs', 'JobController@index')->name('job.index');
    Route::get('jobs/create', 'JobController@create')->name('job.create');
    Route::post('jobs', 'JobController@store')->name('job.store');
    Route::get('jobs/{job}', 'JobController@show')->name('job.show');
    Route::get('jobs/{job}/edit', 'JobController@edit')->name('job.edit');
    Route::put('jobs/{job}', 'JobController@update')->name('job.update');
    Route::delete('jobs/{job}', 'JobController@destroy')->name('job.destroy');
    Route::get('job/{id}/status/{status}', 'JobController@changeJobStatus');

    Route::get('company/{company}/edit', 'CompanyController@editCompany')->name('company.edit.form');
    Route::put('company/{company}', 'CompanyController@updateCompany')->name('company.update.form');

    // followers route
    Route::get('followers', 'CompanyController@getFollowers')->name('followers.index');
    Route::post('/report-to-candidate', 'CandidateController@reportCandidate')->name('report.to.candidate');

    Route::get('manage-subscriptions', 'SubscriptionController@index')->name('manage-subscription.index');
    Route::get('transaction', 'TransactionController@index')->name('transaction.index');
    Route::post('purchase-subscription', 'SubscriptionController@purchaseSubscription')->name('purchase-subscription');
    Route::get('/paypal-status', 'PaypalController@getPaymentStatus')->name('status');
    Route::get('payment-method/{plan}', 'SubscriptionController@showPaymentSelect')->name('payment-method-screen');
    Route::get('paypal-payment/{plan}', 'PaypalController@oneTimePayment')->name('paypal-payment');
    Route::post('purchase-trial-subscription',
        'SubscriptionController@purchaseTrialSubscription')->name('purchase-trial-subscription');
    Route::get('payment-success', 'SubscriptionController@paymentSuccess')->name('payment-success');
    Route::get('failed-payment', 'SubscriptionController@handleFailedPayment')->name('failed-payment');
    Route::post('cancel-subscription', 'SubscriptionController@cancelSubscription')->name('cancel-subscription');
    Route::get('invoices/{invoiceId}', 'TransactionController@getTransactionInvoice');

});
// web routes (i.e landing pages)
Route::group(['namespace' => 'Web', 'middleware' => ['xss', 'setLanguage']], function () {
    Route::get('/', 'HomeController@index')->name('front.home');
    Route::get('/get-jobs-search', 'HomeController@getJobsSearch')->name('get.jobs.search');
    Route::get('/search-jobs', 'JobController@index')->name('front.search.jobs');
    Route::get('/job-details/{uniqueId?}', 'JobController@jobDetails')->name('front.job.details');
    Route::get('/company-lists', 'CompanyController@getCompaniesLists')->name('front.company.lists');
    Route::get('/candidate-lists',
        'CandidateController@getCandidatesLists')->name('front.candidate.lists')->middleware('role:Admin|Employer');
    Route::get('/company-details/{uniqueId?}', 'CompanyController@getCompaniesDetails')->name('front.company.details');
    Route::get('/about-us', 'AboutUsController@FAQLists')->name('front.about.us');
    Route::get('/candidate-profile', function () {
        return view('web.profile.candidate_profile');
    })->name('front.candidate.profile');
    Route::get('/front-register', 'RegisterController@candidateRegister')->name('front.register');
    Route::get('/candidate-register', 'RegisterController@candidateRegister')->name('candidate.register');
    Route::get('/employer-register', 'RegisterController@employerRegister')->name('employer.register');
    Route::get('/privacy-policy-list', 'PrivacyPolicyController@showPrivacyPolicy')->name('privacy.policy.list');
    Route::get('/terms-conditions-list', 'PrivacyPolicyController@showTermsConditions')->name('terms.conditions.list');
    Route::get('/contact', function () {
        return view('web.contact.index');
    })->name('front.contact');
    Route::post('/send-contact-mail', 'HomeController@sendContactEmail')->name('send.contact.email');
    Route::post('/register', 'RegisterController@register')->name('front.save.register');

    //Blog Listing
    Route::get('/posts', 'PostController@getBlogLists')->name('front.post.lists');
    Route::get('/posts-details/{post}', 'PostController@getBlogDetails')->name('front.posts.details');
    Route::get('/posts-by-category/{postCategory}',
        'PostController@getBlogDetailsByCategory')->name('front.blog.category');

    //Candidate Show routes
    Route::get('candidate-details/{uniqueId}',
        'CandidateController@getCandidateDetails')->name('front.candidate.details');

    //Change language
    Route::post('/change-language', 'HomeController@changeLanguage');
});

Route::group(['middleware' => ['xss', 'verified.user']], function () {
    Route::get('candidate-details/{uniqueId}',
        'Web\CandidateController@getCandidateDetails')->name('front.candidate.details');
});

Route::group([
    'middleware' => ['auth', 'role:Candidate', 'xss', 'verified.user'], 'prefix' => 'candidate',
    'namespace'  => 'Candidates',
],
    function () {
        //dashboard
        Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');

        Route::get('/profile', 'CandidateController@editProfile')->name('candidate.profile');
        Route::post('update-profile', 'CandidateController@updateProfile')->name('candidate-profile.update');

        Route::get('edit-profile', 'CandidateController@editCandidateProfile')->name('candidate.edit.profile');
        Route::post('edit-change-password', 'CandidateController@changePassword');
        Route::post('edit-profile-update', 'CandidateController@profileUpdate');

        Route::post('/resumes', 'CandidateController@uploadResume')->name('candidate.resumes');
        Route::get('/media/{media}', 'CandidateController@downloadResume')->name('download.resume');
        Route::delete('/resumes/{media}', 'CandidateController@deletedResume')->name('download.destroy');

        Route::post('experience', 'CandidateProfileController@createExperience')->name('candidate.create-experience');
        Route::get('/{candidateExperience}/edit-experience',
            'CandidateProfileController@editExperience')->name('candidate.edit-experience');
        Route::put('candidate-experience/{candidateExperience}', 'CandidateProfileController@updateExperience');
        Route::delete('candidate-experience/{candidateExperience}',
            'CandidateProfileController@destroyExperience')->name('experience.destroy');
        Route::delete('candidate-experience/{candidateExperience}',
            'CandidateProfileController@destroyExperience')->name('experience.destroy');

        // candidate education
        Route::post('education', 'CandidateProfileController@createEducation')->name('candidate.create-education');
        Route::get('/{candidateEducation}/edit-education',
            'CandidateProfileController@editEducation')->name('candidate.edit-education');
        Route::put('candidate-education/{candidateEducation}', 'CandidateProfileController@updateEducation');
        Route::delete('candidate-education/{candidateEducation}',
            'CandidateProfileController@destroyEducation')->name('education.destroy');

        // favourite jobs listing routes.
        Route::get('favourite-jobs', 'CandidateController@showFavouriteJobs')->name('favourite.jobs');

        // favourite company listing routes.
        Route::get('favourite-companies', 'CandidateController@showFavouriteCompanies')->name('favourite.companies');

        //applied job list routes.
        Route::get('applied-jobs', 'CandidateController@showCandidateAppliedJob')->name('candidate.applied.job');
        Route::get('applied-jobs/{jobApplication}',
            'CandidateController@showAppliedJobs')->name('candidate.applied.job.show');

        // cv builder list routes.
        Route::post('update-general-profile',
            'CandidateController@updateGeneralInformation')->name('candidate.general.profile.update');
        Route::get('get-cv-template', 'CandidateController@getCVTemplate')->name('candidate.cv.template');
        Route::post('update-online-profile',
            'CandidateController@updateOnlineProfile')->name('candidate.online.profile.update');

        // job alert routes.
        Route::get('job-alert', 'CandidateController@editJobAlert')->name('candidate.job.alert');
        Route::post('job-alert', 'CandidateController@updateJobAlert')->name('candidate.job.alert.update');
    });

// candidates route without name space
Route::group(['middleware' => ['auth', 'role:Candidate', 'xss', 'verified.user'], 'prefix' => 'candidate'], function () {

    // Read notification
    Route::post('/notification/{notification}/read',
        'NotificationController@readNotification')->name('read-notification');
    Route::post('/read-all-notification', 'NotificationController@readAllNotification')->name('read-all-notification');

    Route::post('/email-job', 'Web\JobController@emailJobToFriend')->name('email.job');

    Route::post('/save-favourite-job', 'Web\JobController@saveFavouriteJob')->name('save.favourite.job');
    Route::post('/report-job', 'Web\JobController@reportJobAbuse')->name('report.job.abuse');

    Route::post('apply-job', 'Web\JobApplicationController@applyJob')->name('apply-job');

    Route::post('/save-favourite-company',
        'Web\CompanyController@saveFavouriteCompany')->name('save.favourite.company');
    Route::post('/report-to-company', 'Web\CompanyController@reportToCompany')->name('report.to.company');

    Route::get('apply-job/{jobId}', 'Web\JobApplicationController@showApplyJobForm')->name('show.apply-job-form');

});
Route::group(['middleware' => ['web']], function () {
    Route::get('login/{provider}', 'Auth\Front\SocialAuthController@redirect');
    Route::get('login/{provider}/callback', 'Auth\Front\SocialAuthController@callback');
});

// upgrade to v4.2.0
Route::get('/upgrade-to-v4-2-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AddIsFullSliderSettingSeeder']);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AddIsSliderActiveDeactiveSeeder']);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'RenameIsActiveToSlierIsActiveInSettingSeeder']);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AddRecordNotificationSetting']);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'UpdateNotificationSettingAdminTypeSeeder']);
});

// upgrade to v4.4.0
Route::get('/upgrade-to-v4-4-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AddEnableGoogleRecaptchaSeeder']);
});

// upgrade to v4.5.0
Route::get('/upgrade-to-v4-5-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'RemoveProviderUniqueRuleFromSocialAccountsSeeder']);
});

// upgrade to v6.0.0
Route::get('/upgrade-to-v6-0-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'FrontSettingAdvertiseImageSeeder']);
});

// upgrade to v6.1.0
Route::get('/upgrade-to-v6-1-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'CreateDefaultCurrencySeeder']);
});
