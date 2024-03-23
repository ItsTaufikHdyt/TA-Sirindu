<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Admin\User\UserRepository;
use App\Repositories\Admin\Core\User\UserRepositoryInterface;
use App\Repositories\Admin\Anak\AnakRepository;
use App\Repositories\Admin\Core\Anak\AnakRepositoryInterface;
use App\Repositories\Admin\Fuzzy\FuzzyRepository;
use App\Repositories\Admin\Core\Fuzzy\FuzzyRepositoryInterface;

class RepositoriesServiceProvider extends ServiceProvider
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
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
            AnakRepositoryInterface::class,
            AnakRepository::class,
            FuzzyRepositoryInterface::class,
            FuzzyRepository::class,
        );
    }
}
