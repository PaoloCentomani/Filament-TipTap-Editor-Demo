<?php

use Database\Seeders\TasksSeeder;
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
        Schema::create('task_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model_type'); // tablecron
            $table->string('model_type_class')->nullable();
            $table->string('model_type_id_column')->default('id');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // descron
            $table->foreignId('task_type_id')
                ->index()
                ->nullable()
                ->constrained('task_types');
            $table->string('model_type'); // tablecron
            $table->string('model_type_class')->nullable();
            $table->string('model_type_id_column')->default('id');
            $table->unsignedInteger('weight')->default(0); // ordcron
            $table->integer('days_offset')->default(0); // ggcron
            $table->text('days_offset_field')->nullable(); // ggfldcron
            $table->foreignId('days_offset_task_id')
                ->index()
                ->nullable()
                ->constrained('tasks'); // ggidcron
            $table->boolean('attach_documents')->default(false); // doccron
            $table->text('trigger_condition')->nullable(); // checkfldcron, checkfldcron1, checkfldcron2
            $table->json('post_update_actions')->nullable(); // afterfldcron, aftervalcron, afterfld2cron, afterval2cron
            $table->text('post_update_condition')->nullable(); // aftercheckwherecron
            $table->foreignId('previous_task_id')
                ->index()
                ->nullable()
                ->constrained('tasks'); // previdcron
            $table->boolean('is_last')->default(0); // islastcron
            $table->json('conditions')->nullable()->comment('Condizioni di inclusione/esclusione');
            $table->unsignedInteger('external_id')->index()->nullable(); // idcron
            $table->timestamps();
        });

        Schema::create('email_template_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_template_id')
                ->index()
                ->constrained('email_templates')
                ->cascadeOnDelete();
            $table->foreignId('task_id')
                ->index()
                ->constrained('tasks')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_template_task');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_types');
    }
};
