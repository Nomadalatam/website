@extends('web.layouts.app')
@section('title')
    {{ __('messages.post.post_details') }}
@endsection
@section('content')
    <!-- ===== Start of Candidate Profile Header Section ===== -->
    <section class="page-header blog-page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ __('messages.post.post_details') }}</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== End of Candidate Header Section ===== -->

    <section class="ptb80" id="blog-post">
        <div class="container">
            <div class="col-md-8 col-xs-12 post-content-wrapper">

                <div class="post-title">
                    <h2>{{ html_entity_decode($blog->title) }}</h2>

                    <div class="post-detail">
                        <span><i class="fa fa-user"></i>{{ $blog->user->full_name }}</span>
                        <span><i class="fa fa-clock-o"></i>{{ $blog->created_at->format('jS F, Y') }}</span>
                    </div>
                </div>

                <div class="post-content">

                    <div class="post-img">
                        <img src="{{ !empty($blog->blog_image_url)?$blog->blog_image_url:asset('web/img/blog_default_image.jpg') }}"
                             alt="">
                    </div>
                    <p>{!! !empty($blog->description)? nl2br(($blog->description)):__('messages.common.n/a') !!}</p>


                    @auth
                        @role('Candidate')
                        <ul class="social-btns list-inline mt20">
                            <li>
                                <a href="#" class="social-btn-roll facebook">
                                    <div class="social-btn-roll-icons">
                                        <i class="social-btn-roll-icon fa fa-facebook"></i>
                                        <i class="social-btn-roll-icon fa fa-facebook"></i>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="social-btn-roll twitter">
                                    <div class="social-btn-roll-icons">
                                        <i class="social-btn-roll-icon fa fa-twitter"></i>
                                        <i class="social-btn-roll-icon fa fa-twitter"></i>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="social-btn-roll google-plus">
                                    <div class="social-btn-roll-icons">
                                        <i class="social-btn-roll-icon fa fa-google-plus"></i>
                                        <i class="social-btn-roll-icon fa fa-google-plus"></i>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="social-btn-roll pinterest">
                                    <div class="social-btn-roll-icons">
                                        <i class="social-btn-roll-icon fa fa-pinterest"></i>
                                        <i class="social-btn-roll-icon fa fa-pinterest"></i>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="social-btn-roll linkedin">
                                    <div class="social-btn-roll-icons">
                                        <i class="social-btn-roll-icon fa fa-linkedin"></i>
                                        <i class="social-btn-roll-icon fa fa-linkedin"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        @endrole
                    @endauth
                </div>
            </div>
            @include('web.blogs.blog-sidebar')
        </div>
    </section>

@endsection
