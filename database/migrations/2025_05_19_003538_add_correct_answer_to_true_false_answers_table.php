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
        Schema::table('true_false_answers', function (Blueprint $table) {
            $table->boolean('correct_answer')->after('question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('true_false_answers', function (Blueprint $table) {
            $table->dropColumn('correct_answer');
        });
    }
};
