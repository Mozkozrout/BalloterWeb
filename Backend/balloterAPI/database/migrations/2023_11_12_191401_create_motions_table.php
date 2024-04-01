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
        Schema::create('motions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->foreignId('added_by')->constrained('persons');
            $table->timestamps();
        });

        Schema::table('ballots', function($table) {
            $table->foreign('motion')->references('id')->on('motions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ballots', function($table) {
            $table->dropForeign(['motion']);
        });

        Schema::dropIfExists('motions');
    }
};
