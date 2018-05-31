<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestTable
 */
class CreateTestTable extends Migration
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
            $table->string('api_token', 60)->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('integration_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('client_id');
            $table->string('redirect_uri');
            $table->string('authorize_uri');
            $table->string('token_uri');
            $table->string('client_secret');
            $table->string('api_uri');
            $table->timestamps();
        });

        Schema::create('user_integrations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->integer('access_token_expires_in')->nullable();
            $table->string('token_type')->nullable();
            $table->string('scope')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('integration_server_id')->unsigned()->index();
            $table->foreign('integration_server_id')->references('id')->on('integration_servers')->onDelete('cascade');
            $table->timestamps();
            //$table->unique(['integration_server_id', 'user_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_integrations');

        Schema::dropIfExists('integration_servers');

        Schema::dropIfExists('users');
    }
}
