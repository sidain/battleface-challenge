<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'age',
        // 'currency_id' ,
        // 'start_Date',
        // 'end_Date',

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->string('age_list')->nullable();
            $table->string('currency_id')->nullable();
            $table->decimal('total',9,3)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('quotations');
    }
}
