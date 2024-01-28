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
      Schema::create('locales', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable(false);
        $table->string('language_alias')->nullable(false);
        $table->string('entity')->nullable(false);
        $table->integer('entity_id')->nullable(false);
        $table->string('key')->nullable(false);
        $table->text('value')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('locales');
    }
};
