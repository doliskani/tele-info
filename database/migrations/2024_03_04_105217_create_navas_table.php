<?php

use App\Models\Nava;
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
        Schema::create('navas', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type");
            $table->longText("content")->nullable();
            $table->string("file_urls");

            $table->string("sound_id")->nullable();
            $table->string("lecture_sound_id")->nullable();
            $table->string("qari_sound_id")->nullable();
            $table->string("style_sound_id")->nullable();
            $table->string("video_stream")->nullable();

            $table->string("done" , 50);
            $table->text("log_info");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navas');
    }
};


