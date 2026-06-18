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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('admin_name')->comment('Name of the person responsible for the organisation');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('county')->comment('State, Province, County, etc.');
            $table->string('postcode')->comment('Postal code or ZIP code');
            $table->string('country')->default('United Kingdom');
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
