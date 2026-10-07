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
        Schema::create('tb_account', function (Blueprint $table) {
           
            $table->increments('id_act');

            $table->string('number_act', 50);

            $table->string('type_act', 50);

            $table->string('desc_act', 100)
                ->nullable();

            $table->decimal('saldo_act', 15, 2)
                ->default(0);

            // Precisa ser INT UNSIGNED
            // porque tb_bank.id_bnk usa increments()
            $table->unsignedInteger('fk_bnk');

            $table->foreign('fk_bnk')
                ->references('id_bnk')
                ->on('tb_bank')
                ->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_account');
    }
};
