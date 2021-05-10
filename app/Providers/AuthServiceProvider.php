<?php

namespace App\Providers;

use App\Models\Node;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::before(function ($user){
//            return $user->isAdmin();
//        });
//
        Gate::define('admin',function (User $user) {
            if($user->level()=='admin'){
                return true;
            }
            return false;
        });

        Gate::define('upload.file',function (User $user, $node) {
            if($user->isApproved($node->id)){
                return true;
            }
            return false;
        });

        Gate::define('delete.file',function (User $user, $node) {
            if($user->isApproved($node->id)){
                return true;
            }
            return false;
        });

        Gate::define('add.node',function (User $user, $node) {
            if($user->level()=='admin' && ($node->type=='main' || $node->type=='sub')){
                return true;
            }
            return false;
        });

        Gate::define('delete.node',function (User $user, $node) {
            if($user->level()=='admin'){
                return true;
            }
            return false;
        });
//
//        Gate::after(function ($user){
//            return $user->isAdmin();
//        });
    }
}
