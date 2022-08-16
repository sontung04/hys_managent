<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->integer('parent')->default(0);
            $table->string('name', 255);
            $table->timestamp('birthday', 0)->nullable();
            $table->longText('description')->nullable();
            $table->integer('area')->default(0);
            $table->integer('depart')->default(0);
            $table->tinyInteger('type')->comment('1:Khu vực, 2:Ban, 3:Cơ sở, 4:Đội');
            $table->tinyInteger('status')->default(1)->comment('1:Hoạt động, 0:Không hoạt động');
            $table->text('slogan')->nullable();
            $table->string('song')->nullable();
            $table->string('color')->nullable();
            $table->string('banner')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('tiktok', 255)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('groups');
    }
}
