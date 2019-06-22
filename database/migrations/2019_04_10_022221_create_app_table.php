<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name', 100)->nullable();
            $table->string('app_icon', 200)->nullable();
            $table->text('app_desc')->nullable();
            $table->string('app_site', 100)->nullable();
            $table->string('cb_uri', 200)->nullable();
            $table->string('test_cb_uri', 200)->nullable();
            $table->string('username', 50)->index()->nullable();
            $table->string('posting_public', 53)->nullable();
            $table->string('active_public', 53)->nullable();
            $table->string('secret', 32);
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('app');
    }
}
