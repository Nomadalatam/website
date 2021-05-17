<div class="section-body">
    <div class="col-11 col-md-11 col-sm-11  col-xs-10 d-flex justify-content-end">
        <label for="category"
               class="mr-5 admin-post-category-label">{{ __('messages.post_category.post_category') }}</label>
    </div>
    <div class="row">
        <div class="col-md-2 ml-auto float-right mb-4">
            {{Form::select('drp_category',$category,null,['id'=>'filterCategory','class'=>'form-control', 'placeholder' => 'All'])  }}
        </div>
        <div class="col-md-2 float-right mb-2">
            <input wire:model.debounce.100ms="searchByPost" type="search" id="searchByPost"
                   placeholder=" {{ __('web.common.search') }}" class="form-control">
        </div>
    </div>
    <div class="row">
        @if( count($posts) > 0)
            @forelse($posts as $post)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <article class="article post-box">
                        <div class="article-header">
                            <nav class="cd-stretchy-nav edit-content">
                                <a class="cd-nav-trigger" href="#0">
                                    <span aria-hidden="true"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('posts.edit', $post->id) }}" class="edit-btn text-white">
                                            <span>{{__('messages.common.edit')}}</span>
                                            <i class="fas fa-pen"></i>
                                        </a></li>
                                    <li><a href="#" class="text-white btnDeletePost"
                                           data-id="{{ $post->id }}">
                                            <span>{{__('messages.common.delete')}}</span>
                                            <i class="fas fa-trash"></i>
                                        </a></li>
                                </ul>

                                <span aria-hidden="true" class="stretchy-nav-bg"></span>
                            </nav>
                            <img src="{{ empty($post->blog_image_url) ? asset('assets/img/article-image.png') :$post->blog_image_url }}"
                                 class="article-image"/>
                            <div class="article-title">
                                <h2>
                                    <a href="{{route('posts.show',$post->id)}}">{{ html_entity_decode($post->title) }}</a>
                                </h2>
                            </div>
                        </div>
                        <div class="article-details">
                            <div class="post-detail-category-badge">
                                @foreach($post->postAssignCategories as $counter => $category)
                                    @if($counter < 1)
                                        <span class="font-size-13px post-badge badge-pill {{ $counter }} badge-{{ getBadgeColor($loop->index) }}">{{$category->name}}</span>
                                    @elseif($counter == (count($post->postAssignCategories )) - 1)
                                        <a href="#" data-toggle="dropdown" aria-expanded="false"
                                           class="font-size-13px  badge-pill badge-pill {{ $counter }} badge-{{ getBadgeColor($loop->index) }} text-decoration-none">More</a>
                                        <div class="dropdown-menu more-info-menu background-badges">
                                            <a class="dropdown-item pt-0 more-dropdown ">
                                                <div>
                                                    @foreach($post->postAssignCategories as $counter => $category)
                                                        @if($counter >= 1)
                                                            <br> <span
                                                                    class="font-size-13px badge-pill {{ $counter }} badge-{{ getBadgeColor($loop->index) }}">{{$category->name}}</span>
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="text-left line-height-20px blog-post-description">
                                {!! !empty($post->description) ? $post->description : __('messages.common.n/a') !!}
                            </div>
                            <div class="article-cta text-right">
                                <small class="mb-0">{{$post->created_at->diffForHumans()}}</small>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
            @endforelse
        @else
            @if($searchByPost == null || empty($searchByPost))
                <div class="col-lg-12 col-md-12 d-flex justify-content-center mt-4">
                    <h5>{{ __('messages.post.no_posts_available') }} </h5>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center mt-4">
                    <h5>{{ __('messages.post.no_posts_found') }} </h5>
                </div>
            @endif
        @endif
    </div>
    <div class="float-right">
        @if($posts->count() > 0)
            {{$posts->links()}}
        @endif
    </div>
</div>

