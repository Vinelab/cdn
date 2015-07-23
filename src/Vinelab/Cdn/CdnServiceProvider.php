<?php

namespace Vinelab\Cdn;

use Illuminate\Support\ServiceProvider;

/**
 * Class CdnServiceProvider.
 *
 * @category Service Provider
 *
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 * @author  Abed Halawi <abed.halawi@vinelab.com>
 */
class CdnServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/cdn.php' => config_path('cdn.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {

        // implementation bindings:
        //-------------------------
        $this->app->bind(
            'Vinelab\Cdn\Contracts\CdnInterface',
            'Vinelab\Cdn\Cdn'
        );

        $this->app->bind(
            'Vinelab\Cdn\Providers\Contracts\ProviderInterface',
            'Vinelab\Cdn\Providers\AwsS3Provider'
        );

        $this->app->bind(
            'Vinelab\Cdn\Contracts\AssetInterface',
            'Vinelab\Cdn\Asset'
        );

        $this->app->bind(
            'Vinelab\Cdn\Contracts\FinderInterface',
            'Vinelab\Cdn\Finder'
        );

        $this->app->bind(
            'Vinelab\Cdn\Contracts\ProviderFactoryInterface',
            'Vinelab\Cdn\ProviderFactory'
        );

        $this->app->bind(
            'Vinelab\Cdn\Contracts\CdnFacadeInterface',
            'Vinelab\Cdn\CdnFacade'
        );

        $this->app->bind(
            'Vinelab\Cdn\Contracts\CdnHelperInterface',
            'Vinelab\Cdn\CdnHelper'
        );

        $this->app->bind(
            'Vinelab\Cdn\Validators\Contracts\ProviderValidatorInterface',
            'Vinelab\Cdn\Validators\ProviderValidator'
        );

        $this->app->bind(
            'Vinelab\Cdn\Validators\Contracts\CdnFacadeValidatorInterface',
            'Vinelab\Cdn\Validators\CdnFacadeValidator'
        );

        $this->app->bind(
            'Vinelab\Cdn\Validators\Contracts\ValidatorInterface',
            'Vinelab\Cdn\Validators\Validator'
        );

        // register the commands:
        //-----------------------
        $this->app['cdn.push'] = $this->app->share(function () {
            return $this->app->make('Vinelab\Cdn\Commands\PushCommand');
        });

        $this->commands('cdn.push');

        $this->app['cdn.empty'] = $this->app->share(function () {
            return $this->app->make('Vinelab\Cdn\Commands\EmptyCommand');
        });

        $this->commands('cdn.empty');

        // facade bindings:
        //-----------------

        // Register 'CdnFacade' instance container to our CdnFacade object
        $this->app['cdn'] = $this->app->share(function () {
            return $this->app->make('Vinelab\Cdn\CdnFacade');
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Cdn', 'Vinelab\Cdn\Facades\CdnFacadeAccessor');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
