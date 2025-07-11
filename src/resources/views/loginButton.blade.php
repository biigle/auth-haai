<div style="text-align: center; margin-top: 1em;">
    <a style="display: block;" href="{{ route('haai-redirect') }}" title="Log in via Helmholtz AAI">
        <img style="width: 216px" src="{{ cachebust_asset('vendor/auth-haai/helmholtz_id_logo_blue.svg') }}">
    </a>
    @if ($errors->has('haai-id'))
        <p class="text-danger text-center">{{ $errors->first('haai-id') }}</p>
    @endif
</div>
