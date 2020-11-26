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
            $table->integer('id')->autoIncrement()->index()->unsigned();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
        });

        DB::connection('mysql')->table('users')->insert([
            [
                'name' => 'Rizwan Sheikh',
                'email' => 'Rizzsheikh100@gmail.com',
                'password' => Hash::make('Rizwan@1234'),
            ],
            [
                'name' => 'Rizwan Sheikh',
                'email' => 'rizwan0978@gmail.com',
                'password' => Hash::make('Rizwan@1234'),
            ],
            [
                'name' => 'Rizwan Sheikh',
                'email' => 'Sheikhrizwan890@gmail.com',
                'password' => Hash::make('Rizwan@1234'),
            ]
            , [
                'name' => 'Rizwan Sheikh',
                'email' => 'rizz12345@gmail.com',
                'password' => Hash::make('Rizwan@1234'),
            ]
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
            $table->integer('user_id')->unsigned();
            $table->integer('role');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::connection('mysql')->table('user_roles')->insert([
            [
                'user_id' => 2,
                'role' => 1,
            ],

        ]);

        Schema::create('user_info', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('salary');
            $table->string('address')->default('');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::connection('mysql')->table('user_info')->insert([
            [
                'user_id'=>2,
                'salary' => '20000',
                'address' => 'xyz',
            ],
            [
                'user_id'=>1,
                'salary' => '30000',
                'address' => 'abc',
            ],
            [
                'user_id'=>3,
                'salary' => '40000',
                'address' => 'pqr',
            ],

        ]);


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
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('user_info');
    }
}
