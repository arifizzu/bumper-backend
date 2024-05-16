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
        Schema::create('fields_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('caption');
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')
                ->references('id')          // form id
                ->on('forms')
                ->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')
                ->references('id')          // type id
                ->on('fields_types')
                ->onDelete('cascade');
            $table->boolean('is_required');
            $table->string('table_name')->nullable();
            $table->string('column_name')->nullable();
            $table->integer('width');
            $table->integer('height');
            $table->integer('x_coordinate');
            $table->integer('y_coordinate');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fields_lists_values', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value');
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')
                ->references('id')          // field id
                ->on('fields')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('fields_locations', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('field_id');
        //     $table->foreign('field_id')
        //         ->references('id')          // field id
        //         ->on('fields')
        //         ->onDelete('cascade');
        //     $table->integer('width');
        //     $table->integer('height');
        //     $table->integer('x_coordinate');
        //     $table->integer('y_coordinate');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('fields_locations');
        Schema::dropIfExists('fields_lists_values');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('fields_types');
    }
};
