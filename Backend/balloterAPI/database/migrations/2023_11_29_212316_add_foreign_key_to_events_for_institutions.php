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
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('institution')->after('end')->nullable();
            $table->foreign('institution')->references('id')->on('institutions');
            $table->dropForeign(['address']);
            $table->dropColumn('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['institution']);
            $table->dropColumn('institution');
            $table->unsignedBigInteger('address');
            $table->foreign('address')->references('id')->on('addresses');
        });
    }
};
