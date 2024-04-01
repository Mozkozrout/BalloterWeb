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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('state', 127);
            $table->string('city', 127);
            $table->string('street', 255);
            $table->string('house_nmr', 127);
            $table->string('zip', 7);
            $table->timestamps();
        });

        Schema::table('institutions', function($table) {
            $table->unsignedBigInteger('address')->after('short_name')->nullable();
            $table->foreign('address')->references('id')->on('addresses');

            $table->dropColumn('street');
            $table->dropColumn('city');
            $table->dropColumn('zip');
            $table->dropColumn('state');
            $table->dropColumn('house_nmr');
        });

        Schema::table('events', function($table) {
            $table->foreign('address')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institutions', function($table) {
            $table->dropForeign(['address']);
            $table->dropColumn('address');
        });

        Schema::table('events', function($table) {
            $table->dropForeign(['address']);
        });

        Schema::dropIfExists('adresses');
    }
};
