<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // UUIDなどが必要な場合に備えてインポート

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既存のレコードをクリアしたい場合
        // DB::table('tasks')->truncate();

        // TaskIdがUUIDの場合、Str::uuid()で生成します
        $now = now();

        DB::table('tasks')->insert([
            // --------------------------------------------------
            // 1. 未完了、未アーカイブのタスク
            // --------------------------------------------------
            [
                // 'id' => Str::uuid(), // TaskIdがUUIDの場合
                'name' => 'DDDの書籍を読む',
                'due_date' => $now->copy()->addDays(7)->format('Y-m-d'),
                'is_done' => false,
                'is_archived' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // --------------------------------------------------
            // 2. 完了済み、未アーカイブのタスク
            // --------------------------------------------------
            [
                // 'id' => Str::uuid(),
                'name' => 'Docker環境のセットアップ',
                'due_date' => $now->copy()->subDays(2)->format('Y-m-d'), // 過去の期日
                'is_done' => true,
                'is_archived' => false,
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(3),
            ],
            // --------------------------------------------------
            // 3. アーカイブ済みのタスク
            // --------------------------------------------------
            [
                // 'id' => Str::uuid(),
                'name' => '古いプロジェクトの整理',
                'due_date' => null, // 期日なし
                'is_done' => true,
                'is_archived' => true,
                'created_at' => $now->copy()->subMonths(1),
                'updated_at' => $now,
            ],
        ]);

        // Eloquent Modelが存在する場合、Task::create([...]) の使用を推奨します。
    }
}
