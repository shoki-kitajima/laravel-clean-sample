<?php
namespace Packages\UseCases\Inputs;

/**
 * 登録時リクエスト
 * リクエストごとのdateformatの違いを吸収
 */
class RegisterTaskInput
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $dueDate;

    /**
     * @param string $name
     * @param string $dueDate
     */
    public function __construct(string $name, string $dueDate)
    {
        $this->name = $name;
        $this->dueDate = date('Y-m-d H:i:s', strtotime($dueDate));
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function dueDate(): string
    {
        return $this->dueDate;
    }
}
