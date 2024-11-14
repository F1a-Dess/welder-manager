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
        Schema::table('student_scores', function (Blueprint $table) {
            // Adding new language detail fields
            $table->integer('class_prep');
            $table->integer('understanding');
            $table->integer('conversation');
            $table->integer('vocabulary');
            $table->integer('weekly');
            $table->integer('k_song');

            // Adding new attitude detail fields
            $table->integer('rci');
            $table->integer('opa');
            $table->integer('ncd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_scores', function (Blueprint $table) {
            // Dropping the new columns
            $table->dropColumn([
                'class_prep', 'understanding', 'conversation', 'vocabulary', 'weekly', 'k_song',
                'rci', 'opa', 'ncd',
            ]);
        });
    }
};
