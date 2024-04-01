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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 31);
            $table->string('surname', 31);
            $table->date('birthdate')->nullable();
            $table->string('id_number', 31)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('city', 127)->nullable();
            $table->string('zip', 7)->nullable();
            $table->string('school', 255)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
        Schema::table('users', function($table) {
            $table->unsignedBigInteger('person')->after('password')->nullable();
            $table->foreign('person')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function($table) {
            $table->dropForeign(['person']);
            $table->dropColumn('person');
        });
        Schema::dropIfExists('persons');
    }
};
