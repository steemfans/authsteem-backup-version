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
            $table->string('app_id', 16);
            $table->string('user_id', 16)->comment('creater');
            $table->string('app_name', 100)->nullable();
            $table->string('app_icon', 200)->nullable();
            $table->text('app_description')->nullable();
            $table->string('website', 100)->nullable();
            $table->string('callback_uri', 200)->nullable();
            $table->string('test_callback_uri', 200)->nullable();
            $table->string('main_key');
            $table->string('posting_key');
            $table->string('active_key');
            $table->string('memo_key');
            $table->smallInteger('status')->default(1);
            $table->timestamps();
            $table->primary('app_id');
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
