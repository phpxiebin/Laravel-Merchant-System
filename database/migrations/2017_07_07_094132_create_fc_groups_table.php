<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFcGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_groups', function (Blueprint $table) {
            //必须字段
            $table->uuid('id');                                             // uuid
            $table->primary('id');                                          // uuid设为主键

            /********* STA 用户添加字段 STA ********/
            $table->string('group_no', 64)->default('')->comment('组编号');
            $table->string('group_info', 64)->default('')->comment('组信息');
            $table->string('yc_group_id', 255)->default('')->comment('云从组编号');
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
        Schema::drop('fc_groups');
    }
}
