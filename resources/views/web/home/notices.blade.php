<section class="pt40 pb80" id="job-post">
    <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12 mb20">
            <h2 class="capitalize text-center">{{ __('web.home_menu.notices') }}</h2>
        </div>
        <div class="col-lg-8 offset-lg-2">
            <marquee direction="up" scrolldelay="200" id="notices">
                @foreach($notices as $notice)
                    <span class="font-weight-bold">
                    {{ html_entity_decode($notice->title) }} | {{ $notice->created_at->diffForHumans() }}<br>
                    {{ date('jS M, Y', strtotime($notice->created_at)) }},
                </span><br>
                    {!! nl2br(strip_tags($notice->description)) !!}<br>
                    <br>
                @endforeach
            </marquee>
        </div>
    </div>
</section>
