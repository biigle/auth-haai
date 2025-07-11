@extends('app')

@section('title', 'Sign up via Helmholtz AAI')
@section('show-navbar', false)

@section('content')
<div class="container">
    <div class="row center-form">
        <div class="col-md-4 col-sm-6">
            <h1 class="logo  logo--standalone"><a href="{{ route('home') }}" class="logo__biigle">BIIGLE</a></h1>
            <form class="well clearfix" role="form" method="POST" action="{{ route('haai-register') }}">

                <p class="lead text-center">Create an account</p>

                <p>
                    Please enter the information below to finish your sign-up.
                </p>

                <div class="form-group{{ $errors->any() ? ' has-error' : '' }}">
                    @if ($errors->any())
                        <span class="help-block">{{ $errors->first() }}</span>
                    @endif
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-building"></i>
                        </div>
                        <input type="text" placeholder="Affiliation (institute name, company, etc.)" class="form-control" name="affiliation" value="{{ old('affiliation') }}">
                    </div>
                </div>

                @mixin('registrationForm')

                @include('auth.partials.privacy-checkbox')
                @include('auth.partials.terms-checkbox')

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-success btn-block" value="Sign up" onclick="this.disabled=true;this.form.submit();">

            </form>
            <p class="clearfix">
                <a href="{{ route('home') }}" class="">Cancel</a>
                <a href="{{ url('login') }}" class="pull-right" title="Log in">Log in</a>
            </p>
        </div>
    </div>
</div>
@include('partials.footer', [
    'positionAbsolute' => true,
])
@endsection
