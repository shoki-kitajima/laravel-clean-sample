<?php
namespace Packages\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\UseCases\ViewAllTaskInterface;
use Packages\UseCases\ViewAllTaskInteractor;
use Packages\UseCases\RegisterTaskInterface;
use Packages\UseCases\RegisterTaskInteractor;
use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\Infrastructures\EloquentTaskRepository;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // repo
        $this->app->bind(
            TaskRepositoryInterface::class,
            EloquentTaskRepository::class
        );

        // viewAll
        $this->app->bind(
            ViewAllTaskInterface::class,
            ViewAllTaskInteractor::class
        );
        // register
        $this->app->bind(
            RegisterTaskInterface::class,
            RegisterTaskInteractor::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
