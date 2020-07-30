<?php
namespace Packages\UseCases;

use Packages\UseCases\Inputs\ToggleIsDoneTaskInput;

/**
 * 完了toggleインターフェース
 */
interface ToggleIsDoneTaskInterface
{
    /**
     * @param ToggleDoneTaskInput $input
     *
     * @return void
     */
    public function handle(ToggleIsDoneTaskInput $input): void;
}
