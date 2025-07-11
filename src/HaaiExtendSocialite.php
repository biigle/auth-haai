<?php

namespace Biigle\Modules\AuthHaai;

use SocialiteProviders\Manager\SocialiteWasCalled;

class HaaiExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('haai', Provider::class);
    }
}
