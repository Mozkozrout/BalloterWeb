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
        Schema::create('ballot_person', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ballot_id');
            $table->foreign('ballot_id')->references('id')->on('ballots');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->enum('role', ['Adjudicator', 'Observer', 'A1', 'A2', 'A3', 'N1', 'N2', 'N3']);
            $table->string('comment', 255)->nullable();
            $table->unsignedTinyInteger('cont_points')->nullable();
            $table->unsignedTinyInteger('str_points')->nullable();
            $table->unsignedTinyInteger('style_points')->nullable();
            $table->tinyInteger('cq_points')->nullable();
            $table->boolean('best_speaker')->default(0);
            $table->boolean('author')->default(0);
            $table->timestamps();
        });

        Schema::table('ballots', function (Blueprint $table) {

            $table->dropForeign(['adjudicator']);
            $table->dropColumn('adjudicator');

            $table->dropForeign(['best_speaker']);
            $table->dropColumn('best_speaker');

            $table->dropForeign(['A1']);
            $table->dropForeign(['A2']);
            $table->dropForeign(['A3']);
            $table->dropForeign(['N1']);
            $table->dropForeign(['N2']);
            $table->dropForeign(['N3']);

            $table->dropColumn('A1');
            $table->dropColumn('A2');
            $table->dropColumn('A3');
            $table->dropColumn('N1');
            $table->dropColumn('N2');
            $table->dropColumn('N3');

            $table->dropColumn('A1_comment');
            $table->dropColumn('A2_comment');
            $table->dropColumn('A3_comment');
            $table->dropColumn('N1_comment');
            $table->dropColumn('N2_comment');
            $table->dropColumn('N3_comment');

            $table->dropColumn('A1_cont_points');
            $table->dropColumn('A2_cont_points');
            $table->dropColumn('A3_cont_points');
            $table->dropColumn('N1_cont_points');
            $table->dropColumn('N2_cont_points');
            $table->dropColumn('N3_cont_points');

            $table->dropColumn('A1_str_points');
            $table->dropColumn('A2_str_points');
            $table->dropColumn('A3_str_points');
            $table->dropColumn('N1_str_points');
            $table->dropColumn('N2_str_points');
            $table->dropColumn('N3_str_points');

            $table->dropColumn('A1_style_points');
            $table->dropColumn('A2_style_points');
            $table->dropColumn('A3_style_points');
            $table->dropColumn('N1_style_points');
            $table->dropColumn('N2_style_points');
            $table->dropColumn('N3_style_points');

            $table->dropColumn('A1_cq_points');
            $table->dropColumn('A2_cq_points');
            $table->dropColumn('A3_cq_points');
            $table->dropColumn('N1_cq_points');
            $table->dropColumn('N2_cq_points');
            $table->dropColumn('N3_cq_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ballot_person');

        Schema::table('ballots', function (Blueprint $table) {

            $table->foreignId('best_speaker')->constrained('persons');
            $table->foreignId('adjudicator')->constrained('persons');

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
        });
    }
};
