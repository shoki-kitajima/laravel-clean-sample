<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // プライマリキーとしてUUIDを使用

            // TaskName
            $table->string('name', 255);

            // DueDate
            $table->date('due_date')->nullable(); // 期日がない場合もあるためnullable

            // isDone
            $table->boolean('is_done')->default(false);

            // isArchived
            $table->boolean('is_archived')->default(false);

            // Laravel標準のタイムスタンプ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
