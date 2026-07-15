<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'student')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'client')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->string('location');
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
