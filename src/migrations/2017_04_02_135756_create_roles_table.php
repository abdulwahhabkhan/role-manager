<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('roleManager.rolesTable'), function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 255)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create(
            'permissions_roles',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('roles_id')->unsigned();
                $table->integer('permissions_id')->unsigned();
                $table->foreign('roles_id')
                    ->references('id')
                    ->on(config('roleManager.rolesTable'))
                    ->onDelete('cascade');
                $table->foreign('permissions_id')
                    ->references('id')
                    ->on(config('roleManager.permissionsTable'))
                    ->onDelete('cascade');
            }
        );

        Schema::create(
            'roles_user',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('roles_id')->unsigned();
                $table->foreign('roles_id')
                    ->references('id')
                    ->on(config('roleManager.rolesTable'))
                    ->onDelete('cascade');
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_user');
        Schema::dropIfExists('permissions_roles');
        Schema::dropIfExists(config('roleManager.rolesTable'));
    }
}
