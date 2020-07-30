<?php
namespace Packages\UseCases;

/**
 * 閲覧インターフェース
 */
interface ViewAllTasksInterface
{
    /**
     * @return array
     */
    public function handle(): array;
}
