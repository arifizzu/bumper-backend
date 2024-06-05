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
         Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')         // users id
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')
                ->references('id')                  // group id
                ->on('groups')
                ->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')         // users id
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('forms_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')
                ->references('id')                  // form id
                ->on('forms')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('forms_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')          // user id
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')
                ->references('id')          // form id
                ->on('forms')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms_logs');
        Schema::dropIfExists('forms');
        Schema::dropIfExists('forms_templates');
        Schema::dropIfExists('groups');
    }
};
