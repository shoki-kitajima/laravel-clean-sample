<?php
namespace Packages\UseCases;

use Packages\Usecases\Inputs\RegisterTaskInput;
use Packages\Domain\Task;

/**
 * 登録インターフェース
 */
interface RegisterTaskInterface
{
    /**
     * @param RegisterTaskInput $input
     *
     * @return Task
     */
    public function handle(RegisterTaskInput $input): Task;
}
