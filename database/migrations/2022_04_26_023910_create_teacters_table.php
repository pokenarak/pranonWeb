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
        Schema::create('teacters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('personnel_id')->nullable()->constrained();
            $table->string('detail')->nullable();
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
        Schema::dropIfExists('teacters');
    }
};
