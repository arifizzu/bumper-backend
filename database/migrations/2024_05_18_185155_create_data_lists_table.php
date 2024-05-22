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
        Schema::create('data_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')
                ->references('id')          // form id
                ->on('forms')
                ->onDelete('cascade');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')
                ->references('id')          // group id
                ->on('groups')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_lists_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->foreign('list_id')
                ->references('id')          // data list id
                ->on('data_lists')
                ->onDelete('cascade');
            $table->string('label');
            $table->integer('order');
            $table->string('column_key');
            $table->string('table_name');
            $table->string('column_name');
            $table->boolean('is_hidden');
            $table->timestamps();
            $table->softDeletes();
        });
 
        Schema::create('data_lists_filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->foreign('list_id')
                ->references('id')          // data list id
                ->on('data_lists')
                ->onDelete('cascade');
            $table->string('label');
            $table->integer('order');
            $table->string('table_name');
            $table->string('column_name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_lists_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->foreign('list_id')
                ->references('id')          // data list id
                ->on('data_lists')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('segment');
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_lists_actions');
        Schema::dropIfExists('data_lists_filters');
        Schema::dropIfExists('data_lists_items');
        Schema::dropIfExists('data_lists');
    }
};
