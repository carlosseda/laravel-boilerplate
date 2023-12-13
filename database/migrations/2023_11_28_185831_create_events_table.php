<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('events', function (Blueprint $table) {
      $table->id();
      $table->string('name'); 
      $table->string('address')->default("Evento online"); 
      $table->decimal('price', 8, 2)->default(0);  
      $table->date('startDate'); 
      $table->date('endDate'); 
      $table->time('startTime');
      $table->time('endTime');
      $table->timestamps();
      $table->softDeletes(); 
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('events');
  }
};
