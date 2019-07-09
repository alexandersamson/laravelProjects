<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class Globals extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('profilepicturesBasePath', '/images/profilepicture/');
        Config::set(['categories' => [
            'posts' => 'posts',
            'casefiles' => 'casefiles',
            'users' => 'users',
            'investigators' => 'users',
            'leaders' => 'users',
            'clients' => 'clients',
            'organizations' => 'organizations',
            'subjects' => 'subjects',
            'licenses' => 'licenses']
        ]);
        Config::set(['categoriesUnformatted' => [
            'posts' => 'posts',
            'casefiles' => 'casefiles',
            'users' => 'users',
            'investigators' => 'investigators',
            'leaders' => 'leaders',
            'clients' => 'clients',
            'organizations' => 'organizations',
            'subjects' => 'subjects',
            'licenses' => 'licenses']
        ]);
        Config::set(['categoriesSingular' => [
            'posts' => 'Post',
            'casefiles' => 'Casefile',
            'users' => 'User',
            'investigators' => 'Investigator',
            'leaders' => 'Leader',
            'clients' => 'Client',
            'organizations' => 'Organization',
            'subjects' => 'Subject',
            'licenses' => 'License']
        ]);
    }
}
