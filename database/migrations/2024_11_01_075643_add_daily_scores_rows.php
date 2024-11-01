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
            $table->integer('UC');
            $table->integer('OV');
            $table->integer('PO');
            $table->integer('UFVi');
            $table->integer('root_visual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_scores', function (Blueprint $table) {
            $table->dropColumn(['UC', 'OV', 'PO', 'UFVi', 'root_visual']);
        });
    }
};
