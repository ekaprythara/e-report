<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('phone', 13)->nullable()->unique();
            $table->foreignId('receiverUnit_id')->unsigned()->nullable()->constrained('receiver_units', 'id')->nullOnDelete();
            $table->string('description', 30)->nullable();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users', 'id')->nullOnDelete();
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
        Schema::dropIfExists('receivers');
    }
}
