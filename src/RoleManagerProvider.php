<?php

namespace Mamikon\RoleManager;

use Illuminate\Support\Facades\Request;
use \Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Mamikon\RoleManager\Commands\RoleMangerCommand;

/**
 * Class RoleManagerProvider
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class RoleManagerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->_extendedValidation();
        $this->_loadParts();
        $this->_publish();
        if ($this->app->runningInConsole()) {
            $this->commands(
                [RoleMangerCommand::class,]
            );
        }
        $roleManager = new RoleManager();
        $roleManager->defineAllPermissions();
        $this->app->instance('Mamikon\RoleManager', $roleManager);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Publish package Components
     *
     * @return void
     */
    private function _publish()
    {
        $this->publishes(
            [
                __DIR__ . '/config.php' => config_path('roleManager.php'),
            ]
        );
        $this->publishes(
            [
                __DIR__ . '/translations'
                => resource_path('lang/vendor/roleManager'),
            ]
        );
        $this->publishes(
            [
                __DIR__ . '/views' => resource_path('views/vendor/RoleManager'),
            ]
        );
    }

    /**
     * Load Package Components
     *
     * @return void
     */
    private function _loadParts()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'roleManager.php'
        );
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'RoleManager');
        $this->loadViewsFrom(__DIR__ . '/views', 'RoleManager');
    }

    /**
     * Add new Validation Types
     *
     * @return void
     */
    private function _extendedValidation()
    {
        Validator::extend(
            'classExist', function ($attribute, $value, $parameters, $validator) {
                if (empty($value)) {
                    return true;
                }
                return class_exists($value);
            }
        );
        Validator::extend(
            'methodExist', function ($attribute, $value, $parameters, $validator) {
                if (!empty(Request::input('class'))) {
                    return method_exists(Request::input('class'), $value);
                }
                return true;
            }
        );

        Validator::replacer(
            'classExist',
            function ($message, $attribute, $rule, $parameters) {
                return "Class does not exist";
            }
        );
        Validator::replacer(
            'methodExist',
            function ($message, $attribute, $rule, $parameters) {
                return
                    "Method in "
                    . Request::input('class')
                    . " class does not exist.";
            }
        );
    }
}
