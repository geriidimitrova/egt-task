<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->tinyInteger('is_admin');
        });

        // Admin
        $admin = new User();
        $admin->fill([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'is_admin' => 1,
        ]);
        $admin->saveOrFail();

        // Customer
        $customer = new User();
        $customer->fill([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer'),
            'is_admin' => 0,
        ]);
        $customer->saveOrFail();
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
