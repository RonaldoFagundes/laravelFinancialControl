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
        Schema::create('tb_bank', function (Blueprint $table) {            

            $table->increments('id_bnk');

            $table->string('number_bnk', 40);
            $table->string('name_bnk', 40);
            $table->string('ein_bnk', 19);
            $table->string('contact_bnk', 40);
            $table->string('desc_bnk', 40);

            $table->boolean('broker_bnk')->default(false);

            //$table->binary('img_bnk')->nullable();
            $table->string('img_bnk', 255)->nullable();

            $table->string('primary', 20)->default('#000000');
            $table->string('secondary', 20)->default('#ffffff');

            $table->timestamps(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_bank');
    }
};
