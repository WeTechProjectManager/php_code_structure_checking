<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('type')->nullable();
            $table->string('short_bio')->nullable();
            $table->text('address')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('image')->nullable();
            $table->integer('image_status')->nullable();
            $table->string('cover_pic')->nullable();
            $table->string('status')->default('active');
            $table->string('login_status')->nullable();
            $table->string('realFake_status')->default('real');
            $table->integer('otp')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        # create default admin
        User::query()->create([
            'name'      => 'Admin',
            //'image'   => '',
            'email'     => 'admin@gmail.com',
            'type'      => 'Admin',
            'password'  => Hash::make('admin@matrimony'),
            'created_at' => Carbon::now()
        ]);
        User::query()->create([
            'name'      => 'User',
            //'image'   => '',
            'email'     => 'user@gmail.com',
            'type'      => 'User',
            'password'  => Hash::make('admin@matrimony'),
            'created_at' => Carbon::now()
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
    }
}
