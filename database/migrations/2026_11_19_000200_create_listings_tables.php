<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('brand_other', 60)->nullable(); // marca scritta a mano se "Altro"

            $table->string('title', 50);
            $table->text('description');
            $table->string('condition', 20); // new | used | defective

            $table->decimal('price', 10, 2)->nullable();
            $table->char('currency', 3)->default('CHF'); // CHF | EUR
            $table->boolean('is_free')->default(false);
            $table->boolean('is_negotiable')->default(false);

            $table->boolean('shipping_available')->default(false);
            $table->decimal('shipping_cost', 8, 2)->nullable();

            // Dati tecnici facoltativi (solo bastoni)
            $table->string('hand', 10)->nullable();       // right | left
            $table->string('shaft_flex', 2)->nullable();  // L | A | R | S | X
            $table->decimal('loft', 4, 1)->nullable();    // gradi

            $table->boolean('show_phone')->default(false);
            $table->string('city');
            $table->foreignId('province_id')->constrained();

            $table->string('status', 20)->default('draft'); // draft | published | sold | expired | suspended
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('sold_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index(['status', 'expires_at']);
        });

        Schema::create('listing_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_main')->default(false);
            $table->timestamps();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'listing_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('listing_photos');
        Schema::dropIfExists('listings');
    }
};
