<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique();
            $table->foreignId('logisticType_id')->constrained('logistic_types', 'id')->cascadeOnDelete();
            $table->foreignId('standardUnit_id')->constrained('standard_units', 'id')->cascadeOnDelete();
            $table->integer('stock');
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
        Schema::dropIfExists('logistics');
    }
}
