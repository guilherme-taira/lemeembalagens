<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltertableProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos',function(Blueprint $table){
            $table->char('INTEGRADO')->nullable();
            $table->string('id_bling')->nullable();
            $table->char('PREPARADO')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos',function(Blueprint $table){
            $table->dropColumn('INTEGRADO');
            $table->dropColumn('id_bling');
            $table->dropColumn('PREPARADO');
        });
    }
}
