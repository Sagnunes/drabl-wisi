<?php

namespace App\Providers;

use App\Interfaces\DigitalCollectionInterface;
use App\Interfaces\FundInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\StatusInterface;
use App\Interfaces\UserRoleInterface;
use App\Interfaces\UserStatusInterface;
use App\Repositories\EloquentDigitalCollectionRepository;
use App\Repositories\EloquentFundRepository;
use App\Repositories\EloquentRoleRepository;
use App\Repositories\EloquentStatusRepository;
use App\Repositories\EloquentUserRoleRepository;
use App\Repositories\EloquentUserStatusRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Repository bindings configuration
     */
    private array $repositoryBindings = [

        'UserRoles' => [
            RoleInterface::class => EloquentRoleRepository::class,
            UserRoleInterface::class => EloquentUserRoleRepository::class,
        ],
        'Statuses' => [
            StatusInterface::class => EloquentStatusRepository::class,
            UserStatusInterface::class => EloquentUserStatusRepository::class,
        ],
        'Fund' => [
            FundInterface::class => EloquentFundRepository::class,
        ],
        'DigitalCollection' => [
            DigitalCollectionInterface::class => EloquentDigitalCollectionRepository::class,
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
