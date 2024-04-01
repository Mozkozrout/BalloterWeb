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
        Schema::create('ballots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament');
            $table->date('date');
            $table->foreignId('adjudicator')->constrained('persons');
            $table->unsignedBigInteger('motion');

            $table->foreignId('team_AFF')->constrained('teams');
            $table->foreignId('team_NEG')->constrained('teams');

            $table->foreignId('A1')->constrained('persons');
            $table->foreignId('A2')->constrained('persons');
            $table->foreignId('A3')->constrained('persons');
            $table->foreignId('N1')->constrained('persons');
            $table->foreignId('N2')->constrained('persons');
            $table->foreignId('N3')->constrained('persons');

            $table->string('A1_comment', 255)->nullable();
            $table->string('A2_comment', 255)->nullable();
            $table->string('A3_comment', 255)->nullable();
            $table->string('N1_comment', 255)->nullable();
            $table->string('N2_comment', 255)->nullable();
            $table->string('N3_comment', 255)->nullable();

            $table->unsignedTinyInteger('A1_cont_points');
            $table->unsignedTinyInteger('A2_cont_points');
            $table->unsignedTinyInteger('A3_cont_points');
            $table->unsignedTinyInteger('N1_cont_points');
            $table->unsignedTinyInteger('N2_cont_points');
            $table->unsignedTinyInteger('N3_cont_points');

            $table->unsignedTinyInteger('A1_str_points');
            $table->unsignedTinyInteger('A2_str_points');
            $table->unsignedTinyInteger('A3_str_points');
            $table->unsignedTinyInteger('N1_str_points');
            $table->unsignedTinyInteger('N2_str_points');
            $table->unsignedTinyInteger('N3_str_points');

            $table->unsignedTinyInteger('A1_style_points');
            $table->unsignedTinyInteger('A2_style_points');
            $table->unsignedTinyInteger('A3_style_points');
            $table->unsignedTinyInteger('N1_style_points');
            $table->unsignedTinyInteger('N2_style_points');
            $table->unsignedTinyInteger('N3_style_points');

            $table->tinyInteger('A1_cq_points');
            $table->tinyInteger('A2_cq_points');
            $table->tinyInteger('A3_cq_points');
            $table->tinyInteger('N1_cq_points');
            $table->tinyInteger('N2_cq_points');
            $table->tinyInteger('N3_cq_points');

            $table->text('decision')->nullable();
            $table->foreignId('adj_winning_team')->constrained('teams');
            $table->foreignId('winning_team')->constrained('teams');
            $table->string('adjucations', 3);
            $table->foreignId('best_speaker')->constrained('persons');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ballots');
    }
};
