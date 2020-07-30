<?php
namespace Packages\UseCases\Inputs;

/**
 * isDoneのtoggle用リクエスト
 * 単なるDTOであり検査はしない
 */
class ToggleIsDoneTaskInput
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     * @param bool $isDone
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
