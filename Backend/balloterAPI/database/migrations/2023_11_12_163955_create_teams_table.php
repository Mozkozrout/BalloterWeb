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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 31);
            $table->unsignedBigInteger('registered_by');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
        Schema::table('persons', function($table) {
            $table->unsignedBigInteger('team')->after('birthdate')->nullable();
            $table->foreign('team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons', function($table) {
            $table->dropForeign(['team']);
            $table->dropColumn('team');
        });
        Schema::dropIfExists('teams');
    }
};
