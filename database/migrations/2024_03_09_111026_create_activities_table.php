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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('process_id');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('status');
            $table->foreign('process_id')
                ->references('id')          // process id
                ->on('processes')
                ->onDelete('cascade');
            $table->foreign('form_id')
                ->references('id')          // form id
                ->on('forms')
                ->onDelete('cascade');
            $table->foreign('reference_id')
                ->references('id')          // activity id
                ->on('activities')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activities_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('trigger_id');
             $table->foreign('activity_id')
                ->references('id')         // activity id
                ->on('activities')
                ->onDelete('cascade');
            $table->foreign('trigger_id')
                ->references('id')         // activity id
                ->on('activities')  
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
        Schema::dropIfExists('activities_relations');
        Schema::dropIfExists('activities');
    }
};
