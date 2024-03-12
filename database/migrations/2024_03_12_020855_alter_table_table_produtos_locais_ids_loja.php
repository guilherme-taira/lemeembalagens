<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTableProdutosLocaisIdsLoja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_produtos_locais',function(Blueprint $table){
            $table->string('id_shopee_loja')->nullable();
            $table->string('id_tray_loja')->nullable();
            $table->string('id_mercadolivre_loja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_produtos_locais',function(Blueprint $table){
            $table->dropColumn('id_shopee_loja');
            $table->dropColumn('id_tray_loja');
            $table->dropColumn('id_mercadolivre_loja');
        });
    }
}
