<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeQuestionTextNullableInQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('question_text')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('question_text')->nullable(false)->change();
        });
    }
}
