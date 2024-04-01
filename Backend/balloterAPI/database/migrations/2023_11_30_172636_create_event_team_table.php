<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });

        Schema::table('teams', function($table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_team');

        Schema::table('teams', function($table) {
            $table->unsignedBigInteger('event_id')->after('name')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
        });
    }
};
