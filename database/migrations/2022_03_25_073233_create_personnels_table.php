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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('people_id');
            $table->string('name');
            $table->string('lastname');
            $table->string('ordianation_name')->nullable();
            $table->string('address');
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthday');
            $table->date('ordain_novice')->nullable();
            $table->date('ordain_monk')->nullable();
            $table->date('ordain_nun')->nullable();
            $table->string('old_temple_name')->nullable();
            $table->string('old_temple_tel')->nullable();
            $table->string('path')->nullable();
            $table->binary('active')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('personnels');
    }
};
