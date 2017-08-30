<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->boolean('bd_week_before')->default(false)->index();
            $table->boolean('bd_week_after')->default(false)->index();
            $table->boolean('exist_phone')->default(false)->index();

            $table->string('phone_last_digit', 4)->nullable()->index();
            $table->enum('gender', ['female', 'male'])->nullable()->index();

            $table->date('start_on')->index();
            $table->date('end_on')->nullable()->index();

            $table->decimal('discount', 5, 2);

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
        Schema::dropIfExists('discounts');
    }
}
