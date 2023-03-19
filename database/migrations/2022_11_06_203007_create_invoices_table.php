<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("invoice_number");
            $table->date('invoice_date');
            $table->date("due_date");
            $table->foreignId("section_name")->constrained('sections')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("product");
            $table->decimal("amount_collection");
            $table->decimal("amount_commission");
            $table->integer("discount");
            $table->string('rate_vate');
            $table->integer('value_vate');
            $table->integer('total');
            $table->string('status');
            $table->integer('status_value');
            $table->string('user');
            $table->string('notes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
