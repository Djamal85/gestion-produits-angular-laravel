<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            // nullable conserve les anciens produits ; nullOnDelete évite de les supprimer
            // automatiquement lorsque leur catégorie disparaît.
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
