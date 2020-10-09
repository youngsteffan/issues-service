<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertPrioritiesInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('priorities')->insert(array('id'=>'1', 'name'=>'Низкий', 'weight'=>'100'));
        DB::table('priorities')->insert(array('id'=>'2', 'name'=>'Средний', 'weight'=>'100'));
        DB::table('priorities')->insert(array('id'=>'3', 'name'=>'Высокий', 'weight'=>'100'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
