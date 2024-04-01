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
        Schema::table('motions', function (Blueprint $table) {
            $table->unsignedBigInteger('edited_by')->after('added_by')->nullable();
            $table->foreign('edited_by')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motions', function (Blueprint $table) {
            $table->dropForeign(['edited_by']);
            $table->dropColumn('edited_by');
        });
    }
};
