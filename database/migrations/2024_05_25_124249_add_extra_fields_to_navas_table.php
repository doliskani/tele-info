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
        Schema::table('navas', function (Blueprint $table) {
            $table->string("type")->nullable()->change();
            $table->string("person_id")->nullable()->after("video_stream");
            $table->string("person")->nullable()->after("person_id");
            $table->string("language_id")->nullable()->after("person");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navas', function (Blueprint $table) {
            $table->string("type")->change();
            $table->dropColumn("person_id");
            $table->dropColumn("person");
            $table->dropColumn("language_id");
        });
    }
};
