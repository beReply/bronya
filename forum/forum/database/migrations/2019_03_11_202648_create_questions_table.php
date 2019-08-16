<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->integer('user_id')->unsigned();   //外键，对应用户
            $table->integer('comments_count')->default(0);  //评论数
            $table->integer('followers_count')->default(1); //关注者数量
            $table->integer('answers_count')->default(0);   //回答者数量
            $table->string('close_comment',8)->default('F'); //是否关闭评论
            $table->string('is_hidden',8)->default('F'); //是否隐藏该问题
            //好了，设置完了
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
        Schema::dropIfExists('questions');
    }
}
