<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('submissions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('form_id')->constrained()->onDelete('cascade');
    $table->json('answers')->nullable();  // nullable, no default
    $table->string('ip_address')->nullable(); // <- This line must exist
    $table->timestamps();
});



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
};
