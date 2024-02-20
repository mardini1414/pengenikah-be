<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBridesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brides', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('instagram', 50);
            $table->string('image_path');
            $table->string('mother_name', 50);
            $table->string('father_name', 50);
            $table->string('address', 50);
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
        Schema::dropIfExists('brides');
    }
}
