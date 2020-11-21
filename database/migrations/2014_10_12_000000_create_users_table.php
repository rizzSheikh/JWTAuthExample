<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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
            $table->id('id')->autoIncrement()->index()->unsigned();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
        });

        DB::connection('mysql')->table('users')->insert([
            'name' => 'Rizwan Sheikh',
            'email' => 'Rizzsheikh100@gmail.com',
            'password' => Hash::make('Rizwan@1234'),
        ]);

        Schema::create('roles', function (Blueprint $table) {
            $table->string('description');
            $table->integer('role_id')->index()->unsigned();
        });

        DB::connection('mysql')->table('roles')->insert([
                [
                    'description' => 'Manager',
                    'role_id' => 1,
                ],
                [
                    'description' => 'Developer',
                    'role_id' => 2,
                ],
                [
                    'description' => 'Other',
                    'role_id' => 3,
                ]
            ]);

        Schema::create('user_roles', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role');

//            $table->foreign('user_id')->references('id')->on('users');
//            $table->foreign('role')->references('role_id')->on('roles');
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
        Schema::dropIfExists('roles');
    }
}
