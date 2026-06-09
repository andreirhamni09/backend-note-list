<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('note_list_tasks', function (Blueprint $table) {
            $table->increments('id_note_list_task');
            $table->unsignedInteger('id_note_lists');
            $table->text('name_task');
            $table->dateTime('task_start_at', $precision = 0)->nullable();
            $table->dateTime('task_end_at', $precision = 0)->nullable();
            $table->enum('status_task', ['true', 'false'])->default('false');
            $table->dateTime('created_at', $precision = 0)->nullable();
            $table->dateTime('updated_at', $precision = 0)->nullable();
            $table->foreign('id_note_lists')->references('id_note_lists')->on('note_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('deleted_at', $precision = 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('note_list_tasks', function (Blueprint $table) {
            $table->dropForeign(['id_note_lists']);
        });
        Schema::dropIfExists('note_list_tasks');
    }
};
