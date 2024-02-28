<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProdutosLocaisPeso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_produtos_locais',function(Blueprint $table){
            $table->string('peso');
            $table->string('altura');
            $table->string('largura');
            $table->string('comprimento');
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
            $table->dropColumn('peso');
            $table->dropColumn('altura');
            $table->dropColumn('largura');
            $table->dropColumn('comprimento');
        });
    }
}
