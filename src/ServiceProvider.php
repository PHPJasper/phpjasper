<?php
namespace PHPJasper;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
class ServiceProvider extends BaseServiceProvider
{/**
     * Register any application services.
     *
     * @return void
     */
    public function register()
{
    $this->registerAliases();
    $this->mergeConfigFrom(
        __DIR__.'/../config/phpjasper.php', 'phpjasper'
    );
}
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/phpjasper.php' => config_path('phpjasper.php'),
        ],'php-jasper-config');
    }

    protected function registerAliases()
    {
        
        $this->app->bind('geekcom.phpjasper', function($app) {
            return new PHPJasper();
        });
      
    }
}