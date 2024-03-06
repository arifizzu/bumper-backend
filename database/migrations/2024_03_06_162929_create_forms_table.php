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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('table_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('forms_template', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')
                ->references('id') // form id
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
        Schema::dropIfExists('forms');
        Schema::dropIfExists('forms_template');
        // Schema::dropIfExists('fields');
        // Schema::dropIfExists('fields_type');
        // Schema::dropIfExists('fields_lists_values');
    }
};
