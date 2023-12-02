<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutboundLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_logistics', function (Blueprint $table) {
            $table->id();
            $table->date('outboundDate');
            $table->foreignId('receiver_id')->unsigned()->nullable()->constrained('receivers', 'id')->nullOnDelete();
            $table->foreignId('inboundLogistic_id')->constrained('inbound_logistics', 'id')->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('description', 30)->nullable();
            $table->boolean('hasExpired');
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outbound_logistics');
    }
}
