<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            config('roleManager.permissionsTable'),
            function (Blueprint $table) {
                $table->increments('id');
                $table->char('name', 255)->unique();
                $table->text('description')->nullable();
                $table->text('class')->nullable();
                $table->text('method')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists(config('roleManager.permissionsTable'));
    }
}
