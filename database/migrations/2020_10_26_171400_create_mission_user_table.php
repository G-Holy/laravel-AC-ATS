<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_user', function (Blueprint $table) {
            $table->foreignId("mission_id")
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId("user_id")
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->boolean("ac_write")->default(true);
            $table->boolean("ac_delete")->default(true);
            $table->boolean("ac_share")->default(true);

            $table->primary(["mission_id", "user_id"]);
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
        Schema::dropIfExists('mission_user');
    }
}
