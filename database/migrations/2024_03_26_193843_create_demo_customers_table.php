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
        Schema::create('demo_customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->date('birthday')->nullable();
            $table->date('date_met')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_worker_switch')->nullable();
            $table->string('condition')->nullable();
            $table->time('time')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demo_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->unsignedInteger('item_quantity')->nullable();
            $table->unsignedInteger('item_price')->nullable();
            $table->date('manufactured_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->string('delivered_from')->nullable();
            $table->string('deliver_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demo_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('store_visited')->nullable();
            $table->date('date_visited')->nullable();
            $table->string('product_bought')->nullable();
            $table->unsignedInteger('total_spend')->nullable();
            $table->string('rating_scale')->nullable();
            $table->string('expectation_met')->nullable();  
            $table->string('feedback')->nullable();  
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_feedbacks');
        Schema::dropIfExists('demo_customers');
        Schema::dropIfExists('demo_items');
    }
};
