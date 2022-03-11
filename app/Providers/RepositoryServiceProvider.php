<?php

namespace App\Providers;

use App\Contracts\CourseContract;
use App\Contracts\EpisodeContract;
use App\Repositories\CourseRepository;
use App\Repositories\EpisodeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CourseContract::class         =>          CourseRepository::class,
        EpisodeContract::class         =>          EpisodeRepository::class,

    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
