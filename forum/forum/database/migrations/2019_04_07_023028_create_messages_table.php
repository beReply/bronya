<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_user_id');//发送私信的用户
            $table->unsignedInteger('to_user_id');//接收私信的用户
            $table->text('body');//私信主体
            $table->string('has_read', 8)->default('F');//私信是否被阅读
            $table->timestamp('read_at')->nullable();//私信被阅读的时间
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
        Schema::dropIfExists('messages');
    }
}
