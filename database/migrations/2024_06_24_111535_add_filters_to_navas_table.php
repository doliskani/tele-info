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
            $table->string("subject_ids")->nullable()->after("language_id");
            $table->string("style_ids")->nullable()->after("subject_ids");
            $table->string("kind_id")->nullable()->after("style_ids");
            $table->string("weight_id")->nullable()->after("kind_id");
            $table->string("persone_id")->nullable()->after("weight_id");
            $table->string("session_id")->nullable()->after("persone_id");
            $table->string("content_type_id")->nullable()->after("session_id");
            $table->string("year_id")->nullable()->after("content_type_id");
            $table->string("occasion_id")->nullable()->after("year_id");
            $table->string("association_id")->nullable()->after("occasion_id");
            $table->string("poem_format_id")->nullable()->after("association_id");
            $table->string("rhythm_id")->nullable()->after("poem_format_id");
            $table->string("melody_id")->nullable()->after("rhythm_id");
            $table->string("dialect_id")->nullable()->after("melody_id");
            $table->string("surah_id")->nullable()->after("dialect_id");
            $table->string("surah_page_id")->nullable()->after("surah_id");
            $table->string("surah_part_id")->nullable()->after("surah_page_id");
            $table->string("hizb_id")->nullable()->after("surah_part_id");
            $table->string("album_id")->nullable()->after("hizb_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navas', function (Blueprint $table) {
            $table->dropColumn("subject_ids");
            $table->dropColumn("style_ids");
            $table->dropColumn("kind_id");
            $table->dropColumn("weight_id");
            $table->dropColumn("persone_id");
            $table->dropColumn("session_id");
            $table->dropColumn("content_type_id");
            $table->dropColumn("year_id");
            $table->dropColumn("occasion_id");
            $table->dropColumn("association_id");
            $table->dropColumn("poem_format_id");
            $table->dropColumn("rhythm_id");
            $table->dropColumn("melody_id");
            $table->dropColumn("dialect_id");
            $table->dropColumn("surah_id");
            $table->dropColumn("surah_page_id");
            $table->dropColumn("surah_part_id");
            $table->dropColumn("hizb_id");
            $table->dropColumn("album_id");
        });
    }
};
