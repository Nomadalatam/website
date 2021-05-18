@extends('web.layouts.app')
@section('title')
    {{ __('web.home') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/web-popular-categories.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection
@section('content')
    <!-- ===== Start of Main Search Section ===== -->
    @if($settings->value)
        <div class="item">
            <section class="main overlay-black">
                <!-- Start of Wrapper -->
                <div class="container wrapper">
                    <h1 class="capitalize text-center text-white"> {{ __('web.home_menu.your_career_starts_now') }}</h1>

                    <!-- Start of Form -->
                    <form class="job-search-form row pt40" action="{{ route('front.search.jobs') }}"
                          method="get">

                        <!-- Start of keywords input -->
                        <div class="col-md-4 col-sm-12 search-keywords">
                            <label for="search-keywords">{{ __('web.home_menu.keywords') }}</label>
                            <input type="text" name="keywords" id="search-keywords"
                                   placeholder="Job title, skill or company"
                                   autocomplete="off">
                            <div id="jobsSearchResults" class="position-absolute w100"></div>
                        </div>

                        <!-- Start of category input -->
                        <div class="col-md-3 col-sm-12 search-categories">
                            <label for="search-categories">{{ __('web.home_menu.any_category') }}</label>
                            <select name="categories" class="selectpicker" id="search-categories"
                                    data-live-search="true"
                                    title="Any Category" data-size="5" data-container="body">
                                @foreach($jobCategories as $key => $jobCategory)
                                    <option value="{{ $key }}">{{ html_entity_decode($jobCategory) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start of location input -->
                        <div class="col-md-3 col-sm-12 search-location">
                            <label for="search-location">{{ __('web.common.location') }}</label>
                            <input type="text" name="location" id="search-location" placeholder="Location">
                        </div>

                        <!-- Start of submit input -->
                        <div class="col-md-2 col-sm-12 search-submit">
                            <button type="submit" class="btn btn-purple btn-effect btn-large"><i
                                        class="fa fa-search"></i>{{ __('web.common.search') }}
                            </button>
                        </div>
                    </form>
                    <!-- End of Form -->

                    <div class="extra-info pt20">
                        <span class="text-left text-white"><b>{{ $dataCounts['jobs'] }}</b> {{ __('web.home_menu.jobs_offers_for') }} <b> {{ __('web.home_menu.you') }}.</b></span>
                    </div>
                </div>
                <!-- End of Wrapper -->
                @if(count($headerSliders) > 0)
                    <div class="search-middle-image">

                    </div>
                @endif
                @if(count($headerSliders) > 0)
                    <div class="owl-carousel header-image-slider" id="image-search-carousel">
                        @foreach($headerSliders as $headerSlider)
                            <div class="item">
                                <div class="display-text">
                                    <img src="{{ $headerSlider->header_slider_url }}" alt="" class="full-width-height">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    @endif
    @if(count($imageSliders) > 0 && $imageSliderActive->value)
        <div class=" {{ ($slider->value == 0) ? 'container' : ' ' }} ">
            <div class="owl-carousel image-slider mt20" id="image-slider-carousel">
                @foreach($imageSliders as $imageSlider)
                    <div class="item">
                        <span class="bg-image"><img src="{{ $imageSlider->image_slider_url }}" alt=""
                                                    class="image-height"></span>
                        <div class="display-text">
                            <img src="{{ $imageSlider->image_slider_url }}" alt=""
                                 class=" {{ ($slider->value == 0) ? 'image-height' : 'full-width-height' }}">
                            @if($imageSlider->description)
                                <div class="content slider-description">
                                    {!! Str::limit($imageSlider->description, 495, ' ...') !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <!-- ===== End of Main Search Section ===== -->

    <!-- ===== Start of Popular Categories Section ===== -->
    <section class="ptb40 {{ (($imageSliderActive->value == 0) && ($settings->value == 0)) ? 'mt80' : ''  }} bg-gray"
             id="categories">
        <div class="container">
            <div class="section-title">
                <h2>{{ __('web.home_menu.popular_categories') }}</h2>
            </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-3 {{ ($loop->last && $loop->iteration == 5) ? 'col-md-offset-4' : '' }} mt30">
                        <div class="top-categories">
                            <div align="center" class="margin-top">
                                <h4 class="category-name"><a
                                            href="{{ route('front.search.jobs',array('categories'=> $category->id)) }}">
                                        {{ html_entity_decode($category->name) }} <span class="d-inline-flex"> ( {{ $category->jobs_count }} )</span>
                                    </a></h4>
                                <br>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ===== End of Popular Categories Section ===== -->

    <!-- ===== Start of Job Post Section ===== -->
    <section class="ptb80 bg-gray" id="job-post">
        <div class="container">
            <!-- Start of Job Post Main -->
            <div class="col-md-12 col-sm-12 col-xs-12 job-post-main">
                <h2 class="capitalize text-center">{{ __('web.home_menu.latest_jobs') }}</h2>
                <!-- Start of Job Post Wrapper -->
                <div class="job-post-wrapper mt40">
                    <div class="row">
                        @if(count($latestJobs) > 0)
                            @if(\Illuminate\Support\Facades\Auth::check() && isset(auth()->user()->country_name) && $latestJobsEnable->value)
                                @if(in_array(auth()->user()->country_name, array_column($latestJobs->toArray(),'country_name')))
                                    @foreach($latestJobs as $job)
                                        @if($job->country_name == auth()->user()->country_name)
                                            @include('web.common.job_card')
                                        @endif
                                    @endforeach
                                    <div class="col-md-12 text-center">
                                        <a href="{{ route('front.search.jobs') }}"
                                           class="btn btn-purple btn-effect mt50">{{ __('web.common.browse_all') }}</a>
                                    </div>
                                @else
                                    <div class="related-job-not-found">
                                        <h5 class="text-center">{{ __('web.home_menu.latest_job_not_available') }}</h5>
                                    </div>
                                @endif
                            @else
                                @foreach($latestJobs as $job)
                                    @include('web.common.job_card')
                                @endforeach
                                <div class="col-md-12 text-center">
                                    <a href="{{ route('front.search.jobs') }}"
                                       class="btn btn-purple btn-effect mt50">{{ __('web.common.browse_all') }}</a>
                                </div>
                            @endif
                        @else
                            <div class="related-job-not-found">
                                <h5 class="text-center">{{ __('web.home_menu.latest_job_not_available') }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End of Job Post Wrapper -->
            </div>
            <!-- End of Job Post Main -->
        </div>
    </section>
    <!-- ===== End of Job Post Section ===== -->

    <!-- ===== Start of Job Post Section ===== -->
    <section class="pb80 bg-gray" id="job-post">
        <div class="container">
            <!-- Start of Job Post Main -->
            <div class="col-md-12 col-sm-12 col-xs-12 job-post-main">
                <h2 class="capitalize text-center">{{ __('web.home_menu.featured_jobs') }}</h2>

                <!-- Start of Job Post Wrapper -->
                <div class="job-post-wrapper mt40">
                    <div class="row">
                        @if(count($featuredJobs) > 0)
                            @foreach($featuredJobs as $job)
                                @include('web.common.job_card')
                            @endforeach
                        @else
                            <div class="related-job-not-found">
                                <h5 class="text-center">{{ __('web.home_menu.featured_job_not_available') }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End of Job Post Wrapper -->
            </div>
            <!-- End of Job Post Main -->
        </div>
    </section>
        <!-- ===== End of Job Post Section ===== -->

        <!-- ===== Start of Featured Companies Section ===== -->
        <section class="pt40 pb80 bg-gray" id="job-post">
            <div class="container">
                <!-- Start of Job Post Main -->
                <div class="col-md-12 col-sm-12 col-xs-12 job-post-main">
                    <h2 class="capitalize text-center">{{ __('web.home_menu.featured_companies') }}
                    </h2>

                    <!-- Start of Job Post Wrapper -->
                    <div class="job-post-wrapper mt40">
                        <div class="row">
                            @if(count($featuredCompanies) > 0)
                                @foreach($featuredCompanies as $company)
                                    @include('web.common.company_card')
                                @endforeach
                                <div class="col-md-12 text-center">
                                    <a href="{{ route('front.company.lists',['is_featured' => true]) }}"
                                       class="btn btn-purple btn-effect mt50">{{ __('web.common.browse_all') }}</a>
                                </div>
                            @else
                                <div class="related-job-not-found">
                                    <h5 class="text-center">{{ __('web.home_menu.featured_companies_not_available') }}</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- End of Job Post Wrapper -->
                </div>
                <!-- End of Job Post Main -->
            </div>
        </section>
        <!-- ===== End of Featured Companies Section ===== -->

        <!-- ===== Start of CountUp Section ===== -->
        <section class="ptb40 bg-gray" id="countup">
            <div class="container">
                <!-- 1st Count up item -->
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <span class="counter text-purple" data-from="0" data-to="{{ $dataCounts['candidates'] }}"></span>
                    <h4>{{ __('messages.front_home.candidates') }}</h4>
                </div>

                <!-- 2nd Count up item -->
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <span class="counter text-purple" data-from="0" data-to="{{ $dataCounts['jobs'] }}"></span>
                    <h4>{{ __('messages.front_home.jobs') }}</h4>
                </div>

                <!-- 3rd Count up item -->
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <span class="counter text-purple" data-from="0" data-to="{{ $dataCounts['resumes'] }}"></span>
                    <h4>{{ __('messages.front_home.resumes') }}</h4>
                </div>

                <!-- 4th Count up item -->
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <span class="counter text-purple" data-from="0" data-to="{{ $dataCounts['companies'] }}"></span>
                    <h4>{{ __('messages.front_home.companies') }}</h4>
                </div>
            </div>
        </section>
        <!-- ===== End of CountUp Section ===== -->

        <!-- ===== Start of Testimonial Section ===== -->
        @if(count($testimonials) > 0)
            @include('web.home.testimonials')
        @endif
        <!-- ===== End of Testimonial Section ===== -->

        <!-- ===== Start of Notices Section ===== -->
        @if(count($notices) > 0)
            @include('web.home.notices')
        @endif
        {{--    {{  getCountries()  }}--}}
        <!-- ===== End of Notices Section ===== -->

    <!-- ===== Start of Pricing Table Section ===== -->
    {{-- <section class="pricing-tables pb80">
        <div class="container">
            <h2 class="capitalize text-center pt30">{{ __('messages.pricings_table') }}</h2>
            <div class="row align-items-stretch">
                <div class="container">
                    <div class="owl-carousel pricing-slider">
                        @foreach($plans as $plan)
                            <div class="item">
                                <div class="col-lg-12 col-md-12 col-sm-12 mt80">
                                    <div class="pricing-table shadow-hover {{ Auth::check() && Auth::user()->hasRole('Candidate') ? 'pricing-height-auto' : 'pricing-height'}}">
                                        <div class="pricing-header">
                                            <h2 title="{{ html_entity_decode($plan->name) }}">{{ html_entity_decode( Str::limit($plan->name, 12, '...') ) }}</h2>
                                        </div>
                                        <div class="pricing-hover">
                                            <span class="amount plan__price">{{empty($plan->salaryCurrency->currency_icon)?'$':$plan->salaryCurrency->currency_icon}}{{ $plan->amount }}</span>
                                        </div>
                                        <div class="pricing-body">
                                            <ul class="list">
                                                <li>{{ $plan->allowed_jobs.' '.($plan->allowed_jobs > 1 ? __('messages.plan.jobs_allowed') : __('messages.plan.job_allowed')) }}</li>
                                            </ul>
                                        </div>
                                        <div class="pricing-footer">
                                            @if(Auth::check() && Auth::user()->hasRole('Candidate'))
                                                <a href="#"
                                                   class="btn btn-blue btn-effect displayNone">{{ __('messages.pricing_table.get_started') }}</a>
                                            @elseif(Auth::check() && Auth::user()->hasRole('Employer'))
                                                <a href="{{ route('manage-subscription.index') }}"
                                                   class="btn btn-blue btn-effect">{{ __('messages.pricing_table.get_started') }}</a>
                                            @elseif(Auth::check() && Auth::user()->hasRole('Admin'))
                                                <a href="#"
                                                   class="btn btn-blue btn-effect displayNone">{{ __('messages.pricing_table.get_started') }}</a>
                                            @else
                                                <a href="{{ route('employer.register') }}"
                                                   class="btn btn-blue btn-effect">{{ __('messages.pricing_table.get_started') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
    </section> --}}
    <!-- ===== End of Pricing Table Section ===== -->

    <!-- ===== Start of Branding Slider Section ===== -->
    @if(count($branding) > 0)
        <section class="bg-light">
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="d-flex justify-content-center">
                            <h2 class="text-center pt40 pb40">{{ __('messages.brands') }}</h2>
                        </div>
                        <div class="owl-carousel" id="brandingSlider">
                            @foreach($branding as $brand)
                                <div class="item">
                                    <div class="branding-item">
                                        <!-- Branding slider -->
                                        <div class="text-center branding-item">
                                            <img src="{{ $brand->branding_slider_url }}" alt="Branding Slider"
                                                 data-toggle="tooltip" data-placement="right"
                                                 title="{{ html_entity_decode($brand->title) }}"/>
                                        </div>
                                        <!-- End Branding slider -->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
        <!-- ===== End of Branding Slider Section ===== -->

        <!-- ===== Start of Recent Blog Section ===== -->
        @if(count($recentBlog) > 0)
            <section class="section pricing-tables ptb40">
                <div class="section-body">
                    <div class="col-12">
                        <div class="container d-flex flex-column">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb40 mt15">
                                <h2 class="capitalize text-center">{{ __('messages.recent_blog') }}</h2>
                            </div>
                            <div class="d-flex justify-content-center flex-wrap">
                                @foreach($recentBlog as $post)
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 web-post-box">
                                        <article class="article">
                                            <div class="article-header">
                                                <img class="article-image"
                                                     src="{{ empty($post->blog_image_url) ? asset('assets/img/nomada-logo.png') : $post->blog_image_url }}"
                                                     alt="Blog Article"/>
                                                <div class="article-title">
                                                    <h2>
                                                        <a href="{{ route('front.posts.details',$post->id) }}">
                                                            {{ html_entity_decode($post->title) }}</a>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="article-details">
                                                <div class="post-detail-category-badge">
                                                    @foreach($post->postAssignCategories as $counter => $category)
                                                        @if($counter < 1)
                                                            <span class="font-size-13px post-badge badge-pill {{ $counter }} badge-{{ getBadgeColor($loop->index) }}">{{html_entity_decode($category->name)}}</span>
                                                        @elseif($counter == (count($post->postAssignCategories )) - 1)
                                                            <div class="dropdown">
                                                                <a href="#" data-toggle="dropdown"
                                                                   id="dropdownMenuButton"
                                                                   aria-haspopup="true" aria-expanded="false"
                                                                   class="font-size-13px badge-pill {{ $counter }} badge-{{ getBadgeColor($loop->index) }} text-decoration-none">More</a>
                                                                <div class="dropdown-menu"
                                                                     aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item">
                                                                        <div>
                                                                            @foreach($post->postAssignCategories as $counter => $category)
                                                                                @if($counter >= 2)
                                                                                    <span
                                                                                            class="font-size-13px badge-pill {{ $counter }} badge-{{ getBadgeColor($loop->index) }}">{{$category->name}}</span>
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="text-left line-height-20px blog-post-description">
                                                    {!! !empty($post->description) ? $post->description : __('messages.common.n/a') !!}
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                <span><img src="{{ $post->user->avatar }}"
                                                           class="rounded-circle thumbnail-rounded"/> {{ $post->user->full_name }}</span>
                                                    <small>{{$post->created_at->diffForHumans()}}</small>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    <!-- ===== End of Recent Blog Section ===== -->

@endsection
@section('page_scripts')
    <script>
        var availableLocation = [];
        let jobsSearchUrl = "{{ route('get.jobs.search') }}";
        @foreach(getCountries() as $county)
        availableLocation.push("{{ $county  }}");
        @endforeach
    </script>
    <script src="{{mix('assets/js/home/home.js')}}"></script>
@endsection

