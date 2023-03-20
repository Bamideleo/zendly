@extends('admin.layouts.master')
@section('content')
    <section class="error_background">
        <div class="error_container">
            <div class="animation_container">
                <div class="animation"></div>
            </div>
            <div class="error_text">
                <div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h3>{{ translate('40') }}</h3><h3 class="revert">{{ translate('4') }}</h3>
                    </div>
                    <h2>{{ translate('Ops!')}}</h2>
                    <p>{{ translate('The page you are requested for')}}
                        <br>
                        {{ translate('is unavailable') }}
                    </p>
                    <a class="text--light border-0 rounded-pill px-3 py-2 btn--success" href="{{url('/')}}">
                        {{ translate('Back to home')}}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
