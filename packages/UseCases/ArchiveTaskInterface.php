<?php
namespace Packages\UseCases;

use Packages\UseCases\Inputs\ArchiveTaskInput;

/**
 * アーカイブインターフェース
 */
interface ArchiveTaskInterface
{
    /**
     * @param ArchiveTaskInput $input
     *
     * @return void
     */
    public function handle(ArchiveTaskInput $input): void;
}
