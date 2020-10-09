<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertStatusesInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('statuses')->insert(array('id'=>'1', 'name'=>'Открыта'));
        DB::table('statuses')->insert(array('id'=>'2', 'name'=>'Закрыта'));
        DB::table('statuses')->insert(array('id'=>'3', 'name'=>'Переоткрыта'));
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
