<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiches', function (Blueprint $table) {
            $table->id();

            // Bien
            $table->string('ville');
            $table->string('type_bien')->default('Maison');
            $table->string('pieces')->nullable();          // « 5 pièces »
            $table->unsignedInteger('surface')->nullable(); // m²
            $table->unsignedBigInteger('prix')->nullable(); // €

            // Diagnostics
            $table->string('dpe_classe', 1)->default('C');
            $table->unsignedInteger('dpe_valeur')->nullable();   // kWh/m².an
            $table->string('ges_classe', 1)->default('C');
            $table->unsignedInteger('ges_valeur')->nullable();   // KgeqCO2/m².an

            // Contenu
            $table->string('accroche')->nullable();  // « Le + : ... »
            $table->text('description')->nullable();
            $table->string('mentions_legales')->nullable();

            // Statut / badge
            $table->string('statut')->default('a_vendre');
            $table->unsignedInteger('statut_jours')->nullable();

            // QR
            $table->string('qr_position')->default('haut_droite');
            $table->string('qr_url')->nullable();

            // Agent
            $table->boolean('agent_visible')->default(true);
            $table->string('agent_nom')->nullable();
            $table->string('agent_telephone')->nullable();
            $table->string('agent_photo_path')->nullable();

            // Média
            $table->string('photo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiches');
    }
};
