<div class="col-md-4 col-xs-11 blog-sidebar">

    <div class="col-md-12 clearfix">
        <h4 class="widget-title">{{ __('web.post_menu.categories') }}</h4>
        <ul class="sidebar-list">
            @foreach($blogCategories as $key => $blogCategory)
                <li><a href="{{ route('front.blog.category',$key)  }}">{{ html_entity_decode($blogCategory) }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-11 clearfix mt30">
        <h4 class="widget-title">{{ __('web.post_menu.popular_post') }}</h4>

        @forelse($popularBlogs as $popularBlog)
            <div class="sidebar-blog-post">

                <div class="thumbnail-post">
                    <a href="{{ route('front.posts.details',$popularBlog->id) }}">
                        <img src="{{ !empty($popularBlog->blog_image_url)?$popularBlog->blog_image_url:asset('assets/img/infyom-logo.png') }}"
                             alt="">
                    </a>
                </div>

                <div class="post-info">
                    <a href="{{ route('front.posts.details',$popularBlog->id) }}"> {{ html_entity_decode($popularBlog->title) }}</a>
                    <span>{{ $popularBlog->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <h6><span class="popular-blog-no-available">
                               {{ __('messages.post.no_posts_available') }}
                            </span></h6>
        @endforelse
    </div>
</div>
