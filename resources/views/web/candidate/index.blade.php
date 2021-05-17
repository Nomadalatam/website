@extends('web.layouts.app')
@section('title')
    {{ __('web.job_seekers') }}
@endsection
@section('content')
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ __('web.job_seekers') }}</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Start of Main Wrapper Section ===== -->
    <section class="find-candidate ptb80">
        @livewire('candidate-search')

    </section>
    <!-- ===== End of Main Wrapper Section ===== -->
@endsection
@section('scripts')
    <script>
        $(document).on('click', '#btnReset', function () {
            $("#All").prop("checked", true);
            $("#searchBy").prop("selectedIndex", 0);
        });
    </script>
@endsection
