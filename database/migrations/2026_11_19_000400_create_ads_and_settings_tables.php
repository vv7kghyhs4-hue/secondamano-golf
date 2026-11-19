<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Un record per ogni posizione pubblicitaria, gestita dal CMS.
        Schema::create('ad_slots', function (Blueprint $table) {
            $table->id();
            $table->string('key', 40)->unique();   // list_feed, gallery_end, listing_below_gallery, listing_before_contact
            $table->string('name');
            $table->text('adsense_code')->nullable();   // codice per il sito
            $table->string('admob_unit_id')->nullable(); // ID unità per le app
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Impostazioni modificabili dal CMS (chiave/valore).
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key', 60)->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('ad_slots');
    }
};
