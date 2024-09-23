<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesMenusTable extends Migration
{
    public function up()
    {
        Schema::create('cases_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('case_name')->nullable();
            $table->string('car_make');
            $table->string('car_year');
            $table->date('case_date')->nullable();
            $table->string('parts');
            $table->string('parts_price');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
