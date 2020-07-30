<?php
namespace Packages\UseCases\Inputs;

/**
 * アーカイブ時のリクエスト
 * 単なるDTOであり検査はしない
 */
class ArchiveTaskInput
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
