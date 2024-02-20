<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wedding_receptions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('address', 50);
            $table->string('google_map', 1000);
            $table->foreignId('invitation_id')->unique()->constrained('invitations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wedding_receptions');
    }
}
