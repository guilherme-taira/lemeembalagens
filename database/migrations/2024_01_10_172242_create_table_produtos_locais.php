<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProdutosLocais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_produtos_locais', function (Blueprint $table) {
             $table->id();
            $table->string('nome');
            $table->string('sku')->unique();
            $table->char('secundario')->nullable();
            $table->string('ean')->nullable();
            $table->float('saldo');
            $table->float('valor');
            $table->float('QTDBAIXA')->nullable();
            $table->string('valorPromocional')->nullable();
            $table->string('dataInicial')->nullable();
            $table->string('dataFinal')->nullable();
            $table->string('desconto')->nullable();
            $table->string('ativo')->nullable();
            $table->string('BaixoSaldo')->nullable();
            $table->char('flag')->nullable();
            $table->string('id_shopee')->nullable();
            $table->string('id_mercadoLivre')->nullable();
            $table->string('tray')->nullable();
            $table->char('INTEGRADO')->nullable();
            $table->string('id_bling')->nullable();
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
        Schema::dropIfExists('table_produtos_locais');
    }
}
