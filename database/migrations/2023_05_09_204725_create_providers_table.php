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
        Schema::create('providers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',50);
            $table->text('description');
            $table->string('slug', 20)->unique();
            $table->string('logo', 200)->nullable();
            $table->string('url', 100)->nullable();
            $table->bigInteger('status')->default(0);
            $table->timestamps();
            $table->foreignUuid('category_id')->constrained(); //->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign('providers_category_id_foreign');
        });

        Schema::dropIfExists('providers');
    }
};
