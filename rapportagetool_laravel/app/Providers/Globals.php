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
            'licenses' => 'licenses',
            'messages' => 'messages']
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
            'licenses' => 'licenses',
            'messages' => 'messages']
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
            'licenses' => 'License',
            'messages' => 'Message']
        ]);
        Config::set(['objectLinks' => [
            'posts' => 'post_id',
            'casefiles' => 'casefile_id',
            'users' => 'user_id',
            'investigators' => 'user_id',
            'leaders' => 'user_id',
            'clients' => 'client_id',
            'organizations' => 'organization_id',
            'subjects' => 'subject_id',
            'licenses' => 'license_id',
            'messages' => 'message_id']
        ]);
    }
}
