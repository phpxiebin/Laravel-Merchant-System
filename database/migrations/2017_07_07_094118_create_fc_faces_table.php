<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFcFacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_faces', function (Blueprint $table) {
            //必须字段
            $table->uuid('id');                                             // uuid
            $table->primary('id');                                          // uuid设为主键

            /********* STA 用户添加字段 STA ********/
            $table->uuid('group_id')->comment('组ID');
            $table->string('face_no', 64)->default('')->comment('人脸编号');
            $table->string('face_info', 64)->default('')->comment('人脸信息');
            $table->string('face_attachment', 255)->default('')->comment('附件地址');
            $table->string('yc_face_id', 255)->default('')->comment('云从人脸编号');
            $table->text('yc_face_feature')->nullable()->comment('云从人脸特征');
            $table->text('face_feature')->nullable()->comment('本地人脸特征');
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
        Schema::drop('fc_faces');
    }
}
