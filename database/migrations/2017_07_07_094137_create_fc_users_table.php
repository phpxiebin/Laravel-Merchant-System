<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFcUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_users', function (Blueprint $table) {
            //必须字段
            $table->uuid('id');                                             // uuid
            $table->primary('id');                                          // uuid设为主键

            /********* STA 用户添加字段 STA ********/
            $table->string('username', 64)->unique()->default('')->comment('用户名');
            $table->string('password', 64)->default('')->comment('用户密码');
            $table->char('salt', 22)->default('')->comment('密码salt');
            $table->rememberToken()->comment('记住我');
            $table->tinyInteger('type')->unsigned()->default(1)->comment('状态 ［0-停用, 1-正常］');
            /********* END 用户添加字段 END ********/

            //必须字段
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fc_users');
    }
}
