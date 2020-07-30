<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Packages\Domain\TaskName;

class TaskNameTest extends TestCase
{
    public function test_半角スペースのみの名前でインスタンス生成できないか()
    {
        $this->expectException(\InvalidArgumentException::class);
        new TaskName('     ');
    }

    public function test_全角スペースのみの名前でインスタンス生成できないか()
    {
        $this->expectException(\InvalidArgumentException::class);
        new TaskName('　　　　');
    }

    public function test_スペースのみの名前でインスタンス生成できないか()
    {
        $this->expectException(\InvalidArgumentException::class);
        new TaskName('　        　　　');
    }

    public function test_スペースまじり名前でインスタンス生成できるか()
    {
        $obj = new TaskName('　　a　　');
        $this->assertTrue($obj instanceof TaskName);
    }

    public function test_valueを取得できるか()
    {
        $taskNameString = '歯を磨く';
        $obj = new TaskName($taskNameString);
        $this->assertSame($obj->value(), $obj->value());
    }
}
