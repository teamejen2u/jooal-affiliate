<?php

// database/migrations/xxxx_xx_xx_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->string('profile_pic')->nullable();
            $table->enum('level', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze');
            $table->integer('xp_points')->default(0);
            $table->decimal('earnings', 10, 2)->default(0);
            $table->integer('sales_count')->default(0);
            $table->integer('click_count')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0);
            $table->integer('rank')->nullable();
            $table->string('referral_code')->unique();
            $table->timestamp('joined_at')->useCurrent();
            $table->string('payment_method')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};





