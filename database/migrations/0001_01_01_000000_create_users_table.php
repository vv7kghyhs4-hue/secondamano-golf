<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Province italiane + Canton Ticino (serve prima degli utenti).
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code', 4)->unique();      // sigla: MI, CO, TI...
            $table->string('name');
            $table->char('country', 2);               // IT oppure CH
            $table->unsignedSmallInteger('sort_order')->default(0);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Dati privati (mai mostrati al pubblico)
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 30);
            $table->string('address');
            $table->string('postal_code', 10);

            // Dati pubblici
            $table->string('nickname', 30)->unique();
            $table->string('avatar_path')->nullable();
            $table->string('account_type', 20)->default('private'); // private | proshop | dealer
            $table->string('company_name')->nullable();
            $table->string('city');
            $table->foreignId('province_id')->constrained();
            $table->boolean('is_federation_member')->default(false); // autodichiarato
            $table->string('golf_club')->nullable();

            // Accesso
            $table->string('password')->nullable();   // vuota se l'utente entra solo con Apple o Google
            $table->string('apple_id')->nullable()->unique();
            $table->string('google_id')->nullable()->unique();
            $table->rememberToken();

            // Consensi
            $table->timestamp('terms_accepted_at')->nullable();
            $table->boolean('newsletter_consent')->default(false);
            $table->timestamp('newsletter_consent_at')->nullable();

            // Amministrazione
            $table->boolean('is_admin')->default(false);
            $table->string('status', 20)->default('active'); // active | suspended | blocked

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('provinces');
    }
};
