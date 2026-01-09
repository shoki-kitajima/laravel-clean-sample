<?php
namespace Tests\Unit;

use Tests\TestCase;
use Packages\UseCases\ViewAllTasksInteractor;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Packages\Domain\Repositories\TaskRepositoryInterface; // ★ 正確なインターフェース名を使用

class ViewAllTasksInteractorTest extends TestCase
{
    private $task;
    private $task2;
    private $mockRepo;
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();

        // ★ 修正箇所：リポジトリのインスタンス化をモックに置き換え
        // TaskRepositoryInterface のモックを作成
        $this->mockRepo = $this->createMock(TaskRepositoryInterface::class);

        // ドメインエンティティの準備
        $this->task = new Task((new TaskId(1)), (new TaskName('タスク1')), (new DueDate('2020-06-22 10:15:30')));
        $this->task2 = new Task((new TaskId(2)), (new TaskName('タスク2')), (new DueDate('2020-06-23 10:15:30')));

        // ユースケースにモックを注入
        $this->useCase = new ViewAllTasksInteractor($this->mockRepo);

        // 🚨 ユニットテストでは外部依存（DB）を避けるため、DB関連のコマンドは削除またはコメントアウト
        // $this->artisan('migrate:fresh --path=packages/Infrastructures/Migrations');
    }

    public function test_タスクデータがある時要素数0より大きい配列が返ってくるか()
    {
        // ★ 修正: 連続する呼び出しに対する戻り値を定義
        $this->mockRepo->method('getAll')
            ->willReturnOnConsecutiveCalls(
                // 1回目の handle() で返される配列
                [$this->task],
                // 2回目の handle() で返される配列
                [$this->task, $this->task2]
            );

        // 1回目の呼び出し: 1件のアサート
        $output = $this->useCase->handle();
        $this->assertSame(1, count($output));

        // 2回目の呼び出し: 2件のアサート (前回の失敗箇所を修正)
        $output = $this->useCase->handle();
        $this->assertSame(2, count($output));
    }

}
