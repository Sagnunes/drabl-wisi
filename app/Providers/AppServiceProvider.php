<?php

namespace App\Providers;

use App\Interfaces\RoleInterface;
use App\Repositories\EloquentRoleRepository;
use App\Repositories\EloquentUserRoleRepository;
use App\Services\UserRoleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Repository bindings configuration
     */
    private array $repositoryBindings = [

        'UserRoles' => [
            RoleInterface::class => EloquentRoleRepository::class,
            UserRoleService::class => EloquentUserRoleRepository::class,
        ]
    ];

    /**
     * Register repository interface bindings
     */
    private function registerRepositoryBindings(): void
    {
        foreach ($this->repositoryBindings as $group => $bindings) {
            foreach ($bindings as $interface => $implementation) {
                $this->app->bind($interface, $implementation);
            }
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositoryBindings();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
