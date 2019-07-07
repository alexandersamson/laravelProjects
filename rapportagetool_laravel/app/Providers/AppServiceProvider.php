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
        Blade::directive('getuserroles', function ($permissionValue) {
            $roles = $this->pp->getPermissionsTextArray($permissionValue);
            if(count($roles) > 0){
                $counter = 0;
                $returnString = "<?php echo (\"";
                foreach($roles as $role){
                    if($counter > 0){
                        $returnString .= " |&nbsp;";
                    }
                    $returnString .= "<span class='text-dark'>$role</span>";
                    $counter++;
                }
                $returnString .= "\"); ?>";
                return $returnString;
            }
                return false;
        });
    }
}


