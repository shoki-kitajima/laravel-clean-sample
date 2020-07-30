<?php
namespace Packages\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\UseCases\ViewAllTasksInterface;
use Packages\UseCases\ViewAllTasksInteractor;
use Packages\UseCases\RegisterTaskInterface;
use Packages\UseCases\RegisterTaskInteractor;
use Packages\UseCases\ToggleIsDoneTaskInterface;
use Packages\UseCases\ToggleIsDoneTaskInteractor;
use Packages\UseCases\ArchiveTaskInterface;
use Packages\UseCases\ArchiveTaskInteractor;
use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\Infrastructures\EloquentModels\EloquentTaskRepository;

/**
 * タスク関連サービスプロバイダ
 * NOTE:repository実装と分けてもよいかも
 */
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
            ViewAllTasksInterface::class,
            ViewAllTasksInteractor::class
        );
        // register
        $this->app->bind(
            RegisterTaskInterface::class,
            RegisterTaskInteractor::class
        );
        // toggleIsDone
        $this->app->bind(
            ToggleIsDoneTaskInterface::class,
            ToggleIsDoneTaskInteractor::class
        );
        // archive
        $this->app->bind(
            ArchiveTaskInterface::class,
            ArchiveTaskInteractor::class
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
