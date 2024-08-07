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
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained()->noActionOnUpdate()->nullOnDelete();
            $table->foreignId('user_id')->unsigned()->nullable();
            $table->string('policy_number');
            $table->string('holder_name');
            $table->enum('type_of_insurance', ['TERM', 'WHOLE', 'UNIVERSAL']);
            $table->decimal('coverage_amount', total: 20, places: 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('insurance_policies', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->noActionOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_policies');
    }
};
