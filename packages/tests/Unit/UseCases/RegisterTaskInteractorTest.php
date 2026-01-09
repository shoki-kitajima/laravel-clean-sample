<?php
namespace Tests\Unit;

use Tests\TestCase;
use Packages\UseCases\RegisterTaskInteractor;
use Packages\UseCases\Inputs\RegisterTaskInput;
use Packages\Domain\Task;
// use Packages\Domain\TaskId; // 不要な Import は削除
// use Packages\Domain\TaskName; // 不要な Import は削除
// use Packages\Domain\DueDate; // 不要な Import は削除
// use Packages\Infrastructures\EloquentModels\EloquentTaskRepository; // EloquentRepository は不要
use Packages\Domain\Repositories\TaskRepositoryInterface; // ★ 正確なインターフェース名を使用

class RegisterTaskInteractorTest extends TestCase
{
    private $input1;
    private $input2;
    private $mockRepo; // ★ プロパティ名を変更
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();

        // ★ 修正箇所：リポジトリのインスタンス化をモックに置き換え
        // TaskRepositoryInterface のモックを作成
        $this->mockRepo = $this->createMock(TaskRepositoryInterface::class);

        $this->input1 = new RegisterTaskInput('タスク1', '2020-06-22T10:15');
        $this->input2 = new RegisterTaskInput('タスク2', '2020-06-23 10:15:30');

        // ユースケースにモックを注入
        $this->useCase = new RegisterTaskInteractor($this->mockRepo);

        // 🚨 ユニットテストでは外部依存（DB）を避けるため、DB関連のコマンドは削除またはコメントアウト
        // $this->artisan('migrate:fresh --path=packages/Infrastructures/Migrations');
    }

    public function test_タスクデータを登録できるか()
    {
        // ★ 修正箇所: 'register' を 'save' に変更
        // 1. リポジトリの save メソッドが、Task オブジェクトを受け取って、Task オブジェクトを返すことを期待する
        $this->mockRepo->method('save') // <--- ここを 'save' に修正
                    // save に渡された Task オブジェクトをそのまま返すように設定
                    ->will(
                        $this->returnCallback(function (Task $task) {
                            // 登録されたTaskオブジェクトがIDを持つことをシミュレートするため、
                            // IDがない場合は適当なIDを割り当てたTaskオブジェクトを返す
                            if (!$task->id()->value()) {
                                $taskId = new \Packages\Domain\TaskId(rand(10, 99));
                                return new Task($taskId, $task->name(), $task->dueDate());
                            }
                            return $task;
                        })
                    );

        // 呼び出し 1
        $res1 = $this->useCase->handle($this->input1);
        $this->assertSame($this->input1->name(), $res1->name()->value());
        $this->assertNotNull($res1->id());

        // 呼び出し 2
        $res2 = $this->useCase->handle($this->input2);
        $this->assertSame($this->input2->name(), $res2->name()->value());
        $this->assertNotNull($res2->id());
    }
}
