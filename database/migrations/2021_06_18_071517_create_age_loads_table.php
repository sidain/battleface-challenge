<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgeLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_loads', function (Blueprint $table) {
            $table->id();
            $table->string('age_range')->nullable();
            $table->integer('age_start')->unsigned()->nullable();
            $table->integer('age_end')->unsigned()->nullable();
            $table->float('load')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();
        });


        DB::table('age_loads')->insert([
            [ 'age_range' => '18-30', 'age_start' => '18',    'age_end' => '30',    'load' => '0.6' , ],
            [ 'age_range' => '31-40', 'age_start' => '31',    'age_end' => '40',    'load' => '0.7' , ],
            [ 'age_range' => '41-50', 'age_start' => '41',    'age_end' => '50',    'load' => '0.8' , ],
            [ 'age_range' => '51-60', 'age_start' => '51',    'age_end' => '60',    'load' => '0.9' , ],
            [ 'age_range' => '61-70', 'age_start' => '61',    'age_end' => '70',    'load' => '1' , ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('age_loads');
    }
}
