<li class="list-group-item clearfix">
    @if ($errors->has('haai-id'))
        <p class="text-danger">{{ $errors->first('haai-id') }}</p>
    @endif
    <img style="width: 153px" src="{{ cachebust_asset('vendor/auth-haai/helmholtz_id_logo_blue.svg') }}">
    @if (\Biigle\Modules\AuthHaai\HelmholtzId::where('user_id', $user->id)->exists())
        <span class="label label-success" title="Your account is connected with Helmholtz AAI">connected</span>
    @else
        <span class="label label-default" title="Your account is not connected with Helmholtz AAI">not connected</span>
        <a href="{{ route('haai-redirect') }}" title="Connect your account with Helmholtz AAI" class="btn btn-default pull-right">
            Connect
        </a>
    @endif
</li>

