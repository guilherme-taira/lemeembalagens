<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sku')->unique();
            $table->char('secundario')->nullable();
            $table->string('ean');
            $table->float('saldo');
            $table->float('valor');
            $table->float('QTDBAIXA');
            $table->string('valorPromocional')->nullable();;
            $table->string('dataInicial')->nullable();;
            $table->string('dataFinal')->nullable();;
            $table->string('desconto')->nullable();;
            $table->string('ativo')->nullable();;
            $table->string('BaixoSaldo')->nullable();
            $table->char('flag')->nullable();;
            $table->string('id_shopee')->nullable();;
            $table->string('id_mercadoLivre')->nullable();;
            $table->string('tray')->nullable();;
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
        Schema::dropIfExists('produtos');
    }
}
