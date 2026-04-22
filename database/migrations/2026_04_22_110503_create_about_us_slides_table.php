<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_us_id')->nullable()->constrained('about_us')->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us_slides');
    }
}
