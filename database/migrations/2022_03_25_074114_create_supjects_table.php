<?php

use Database\Seeders\SupjectSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
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
        Schema::create('supjects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->uniqid();
            $table->string('type');
        });

        Artisan::call('db:seed', [
            '--class' => SupjectSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supjects');
    }
};
