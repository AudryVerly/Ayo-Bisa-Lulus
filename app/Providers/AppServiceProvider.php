<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    // ini merupakan bawaan daei laravel yang digunakan untuk mengatur policy atau aturan
    protected $policies = [

    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        // ini merupakan bagian authorize yang digunakan, yang dimana can tau mana muncul di role apa
        Gate::define('role:SuperAdmin', fn ($user) => $user->role === 'SuperAdmin');
        Gate::define('role:AdminUnit', fn ($user) => $user->role === 'AdminUnit');
        Gate::define('role:StaffUnit', fn ($user) => $user->role === 'StaffUnit');
        Gate::define('role:Mahasiswa', fn ($user) => $user->role === 'Mahasiswa');

        Gate::define('role:AdminOrStaff', fn ($user) => in_array($user->role, ['AdminUnit', 'StaffUnit'])
        );
    }
}
