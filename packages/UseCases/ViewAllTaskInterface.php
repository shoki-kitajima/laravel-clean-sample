<?php
namespace Packages\UseCases;

/**
 * 閲覧インターフェース
 */
interface ViewAllTaskInterface
{
    /**
     * @return array
     */
    public function handle(): array;
}
