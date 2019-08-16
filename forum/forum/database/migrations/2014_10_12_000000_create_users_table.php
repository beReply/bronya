<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar');
            $table->string('confirmation_token'); //token
            $table->smallInteger('is_active')->default(0); //邮箱验证
            $table->integer('question_count')->default(0); //提问数
            $table->integer('answers_count')->default(0); //回答数
            $table->integer('comments_count')->default(0); //评论数
            $table->integer('favotites_count')->default(0); //收藏数
            $table->integer('likes_count')->default(0); //收藏数
            $table->integer('followers_count')->default(0); //被关注数
            $table->integer('followings_count')->default(0); //关注数
            //$table->json('settings')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
