<?php
namespace PHPJasper;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
{
    $this->mergeConfigFrom(
        __DIR__.'/../config/phpjasper.php', 'phpjasper'
    );
}
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/phpjasper.php' => config_path('phpjasper.php'),
        ]);
    }
}