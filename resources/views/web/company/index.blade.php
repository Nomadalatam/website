@extends('web.layouts.app')
@section('title')
    {{ __('messages.company.company_listing') }}
@endsection
@section('content')
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ __('web.companies') }}</h2>
                </div>
            </div>
        </div>
    </section>

    @livewire('company-search', ['isFeatured' => Request::get('is_featured')])
@endsection
