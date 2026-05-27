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
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();
            // Hero
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_slide_1')->nullable();
            $table->string('hero_slide_2')->nullable();
            $table->string('hero_slide_3')->nullable();
            $table->string('hero_slide_4')->nullable();
            $table->string('hero_slide_5')->nullable();
            
            // Stats
            $table->string('stat_1_num')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_2_num')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_3_num')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_4_num')->nullable();
            $table->string('stat_4_label')->nullable();
            
            // About
            $table->string('about_title')->nullable();
            $table->text('about_text_1')->nullable();
            $table->text('about_text_2')->nullable();
            $table->string('about_video')->nullable();
            
            // Section Titles
            $table->string('destinasi_title')->nullable();
            $table->string('destinasi_subtitle')->nullable();
            $table->string('maps_title')->nullable();
            $table->string('maps_subtitle')->nullable();
            
            // CTA
            $table->string('cta_title')->nullable();
            $table->text('cta_text')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepages');
    }
};
