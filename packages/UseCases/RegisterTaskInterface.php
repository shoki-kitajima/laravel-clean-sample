<?php
namespace Packages\UseCases;

use Packages\Usecases\Inputs\RegisterTaskInput;

interface RegisterTaskInterface
{
    public function handle(RegisterTaskInput $input);
}
