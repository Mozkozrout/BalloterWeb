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
        Schema::create('person_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });

        Schema::table('persons', function($table) {
            $table->dropForeign(['team']);
            $table->dropColumn('team');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_team');

        Schema::table('persons', function($table) {
            $table->unsignedBigInteger('team')->after('birthdate')->nullable();
            $table->foreign('team')->references('id')->on('teams');
        });
    }
};
