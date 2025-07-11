<?php

namespace Biigle\Modules\AuthHaai;

use Biigle\Services\Modules;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class ServiceProvider extends BaseServiceProvider
{

   /**
   * Bootstrap the application events.
   *
   * @param Modules $modules
   * @param  Router  $router
   * @return  void
   */
    public function boot(Modules $modules, Router $router)
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'auth-haai');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $router->group([
            'namespace' => 'Biigle\Modules\AuthHaai\Http\Controllers',
            'middleware' => 'web',
        ], function ($router) {
            require __DIR__.'/Http/routes.php';
        });

        $modules->register('auth-haai', [
            'viewMixins' => [
                'loginButton',
                'registerButton',
                'settingsThirdPartyAuthentication',
            ],
        ]);

        $this->publishes([
            __DIR__.'/public/assets' => public_path('vendor/auth-haai'),
        ], 'public');

        Event::listen(
            SocialiteWasCalled::class,
            [HaaiExtendSocialite::class, 'handle']
        );
    }

    /**
    * Register the service provider.
    *
    * @return  void
    */
    public function register()
    {
        //
    }
}
