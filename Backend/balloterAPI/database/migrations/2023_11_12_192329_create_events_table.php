<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 127);
            $table->date('beginning');
            $table->date('end');
            $table->unsignedBigInteger('address');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::table('teams', function($table) {
            $table->unsignedBigInteger('event_id')->after('name')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function($table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::dropIfExists('events');
    }
}
