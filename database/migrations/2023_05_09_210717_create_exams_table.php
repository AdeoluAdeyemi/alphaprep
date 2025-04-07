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
        Schema::create('exams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('provider_id')->constrained(); // ->cascadeOnDelete();
            $table->string('name',100);
            $table->string('slug',20)->unique();
            $table->text('description');
            $table->year('year')->nullable();
            $table->string('logo',200);
            $table->string('version',30)->nullable();
            $table->integer('duration');
            $table->char('timer',1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign('exams_provider_id_foreign');
        });

        Schema::dropIfExists('exams');
    }
};
