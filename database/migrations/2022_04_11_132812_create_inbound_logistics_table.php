<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbound_logistics', function (Blueprint $table) {
            $table->id();
            $table->date('inboundDate');
            $table->foreignId('logistic_id')->constrained('logistics', 'id')->cascadeOnDelete();
            $table->foreignId('supplier_id')->unsigned()->nullable()->constrained('suppliers', 'id')->nullOnDelete();
            $table->integer('amount');
            $table->integer('stock');
            $table->date('expiredDate')->nullable();
            $table->foreignId('logisticProcurement_id')->unsigned()->nullable()->constrained('logistic_procurements', 'id')->nullOnDelete();
            $table->string('description', 30)->nullable();
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
        Schema::dropIfExists('inbound_logistics');
    }
}
