<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();//回答所属用户
            $table->integer('question_id')->index()->unsigned();//回答所属问题
            $table->text('body');//回答主体
            $table->integer('votes_count')->default(0);//被点赞数
            $table->integer('comments_count')->default(0);//被评论数
            $table->string('is_hidden', 8)->default('F');//是否隐藏
            $table->string('close_comment', 8)->default('F');//是否关闭评论
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
        Schema::dropIfExists('answers');
    }
}
