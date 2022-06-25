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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('regis');
            $table->unsignedBigInteger('type_id');
            $table->string('engine_no');
            $table->string('model_no');
            $table->string('chasis_no');
            $table->string('owner');
            $table->string('owner_phone');
            $table->string('brand');
            $table->enum('status',[1,0])->nullable();
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
        Schema::dropIfExists('vehicles');
    }
};
