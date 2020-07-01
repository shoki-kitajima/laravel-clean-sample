<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Packages\Domain\TaskId;

class TaskIdTest extends TestCase
{
    public function test_intでインスタンス生成できるか()
    {
        $obj = new TaskId(1234);
        $this->assertTrue($obj instanceof TaskId);
    }

    public function test_nullでインスタンス生成できるか()
    {
        $obj = new TaskId(null);
        $this->assertTrue($obj instanceof TaskId);
        $this->assertNull($obj->value());
    }

    public function test_負の数でインスタンス生成できないか()
    {
        $this->expectException(\InvalidArgumentException::class);
        $obj = new TaskId(-1234);
    }

    public function test_0でインスタンス生成できないか()
    {
        $this->expectException(\InvalidArgumentException::class);
        $obj = new TaskId(0);
    }

    public function test_文字列でインスタンス生成できないか()
    {
        $this->expectException(\TypeError::class);
        $obj = new TaskId('aaa');
    }
}
