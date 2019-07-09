<?php

namespace App\Providers;

use App\Http\Controllers\Services\PermissionsService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private $pp;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->pp = new PermissionsService();
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasanyrole', function ($expression) {
            $permRequired = explode('|', $expression);
            return $this->pp->checkPermission($this->pp->getBitwiseValue($permRequired),NULL,true,false)['permission'];
        });

        Blade::if('hasallroles', function ($expression) {
            $permRequired = explode('|', $expression);
            return $this->pp->checkPermission($this->pp->getBitwiseValue($permRequired),NULL,false,false)['permission'];
        });
    }
}


