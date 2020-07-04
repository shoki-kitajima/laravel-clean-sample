<?php
namespace Packages\UseCases;

class ArchiveTaskInputData
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }
}
