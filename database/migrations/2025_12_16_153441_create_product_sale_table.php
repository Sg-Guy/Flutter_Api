<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sale', function (Blueprint $table) {
            $table->id();

            // Relation avec la vente
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');

            // Relation avec le produit
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Quantité vendue pour ce produit dans cette vente
            $table->integer('quantity');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sale');
    }
};