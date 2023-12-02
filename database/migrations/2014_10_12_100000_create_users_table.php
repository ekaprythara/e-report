<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('image', 48)->nullable();
            $table->string('username', 20)->unique();
            $table->string('password', 60);
            $table->string('name', 50);
            $table->string('address', 35);
            $table->string('email', 30)->unique();
            $table->string('phone', 13)->unique();
            $table->foreignId('level_id')->unsigned()->nullable()->constrained('levels', 'id')->nullOnDelete();
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
        Schema::dropIfExists('users');
    }
}
