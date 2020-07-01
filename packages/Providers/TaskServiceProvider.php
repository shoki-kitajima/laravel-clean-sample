<?php
namespace Packages\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\UseCases\ViewAllTaskInterface;
use Packages\UseCases\ViewAllTaskInteractor;
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
        $this->app->bind(
            TaskRepositoryInterface::class,
            EloquentTaskRepository::class
        );
        $this->app->bind(
            ViewAllTaskInterface::class,
            ViewAllTaskInteractor::class
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
