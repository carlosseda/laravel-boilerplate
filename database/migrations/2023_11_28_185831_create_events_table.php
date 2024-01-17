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
      $table->integer('town_id')->unsigned()->index()->nullable();
      $table->string('name'); 
      $table->string('address')->default("Evento online"); 
      $table->decimal('price', 8, 2)->default(0);  
      $table->date('start_date'); 
      $table->date('end_date'); 
      $table->time('start_time');
      $table->time('end_time');
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
