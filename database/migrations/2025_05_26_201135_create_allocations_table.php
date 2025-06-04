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
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->foreignId("machine_id")->constrained()->onDelete("cascade");
            $table->foreignId("construction_id")->constrained()->onDelete("cascade");
            $table->foreignId("allocation_end_motive_id")->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocations');
    }
};
