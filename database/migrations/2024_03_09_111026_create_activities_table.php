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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('condition_variable');
            $table->string('condition_operator');
            $table->string('condition_value');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('process_id');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->string('status');
            $table->foreign('process_id')
                ->references('id')          // process id
                ->on('processes')
                ->onDelete('cascade');
            $table->foreign('form_id')
                ->references('id')          // form id
                ->on('forms')
                ->onDelete('cascade');
            // $table->integer('width');
            // $table->integer('height');    
            // $table->integer('x_coordinate');
            // $table->integer('y_coordinate');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activities_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')
                ->references('id')          // activity id
                ->on('activities')
                ->onDelete('cascade');
            $table->integer('w');
            $table->integer('h');    
            $table->integer('x');
            $table->integer('y');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activities_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->foreign('source_id')
                ->references('id')         // activity id
                ->on('activities')
                ->onDelete('cascade');
            $table->foreign('target_id')
                ->references('id')         // activity id
                ->on('activities')  
                ->onDelete('cascade');
            $table->foreign('condition_id')
                ->references('id')         // condition id
                ->on('conditions')  
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')
                ->references('id')         // activity id
                ->on('activities')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('participant_is_user', function (Blueprint $table) {
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('user_id');
            // Primary key
            $table->primary(['participant_id', 'user_id']);

            $table->foreign('participant_id')
                ->references('id')         // participant id
                ->on('participants')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')         // user id
                ->on('users')  
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

         Schema::create('participant_is_role', function (Blueprint $table) {
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('role_id');
            // Primary key
            $table->primary(['participant_id', 'role_id']);

            $table->foreign('participant_id')
                ->references('id')         // participant id
                ->on('participants')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')         // role id
                ->on('roles')  
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
        Schema::dropIfExists('participant_is_user');
        Schema::dropIfExists('participant_is_role');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('activities_relations');
        Schema::dropIfExists('activities_locations');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('conditions');
    }
};
