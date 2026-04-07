<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_variants', function (Blueprint $table) {
            $table->id("productVariantId");
            $table->string("sku")->unique();
            $table->foreignId("productId")
                ->constrained('products', 'productId')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->decimal("purchasePrice")->default(0);
            $table->decimal("unitPrice")->default(0);
            $table->decimal("sellPrice")->default(0);
            $table->decimal("lastUnitPrice")->default(0);
            $table->decimal("shippingAmount")->default(0);

            $table->boolean("discountEnabled")->default(false);
            $table->string("discountType")->default('fixed');
            $table->decimal("discountAmount")->default(0);

            $table->boolean("vatEnabled")->default(false);
            $table->string("vatType")->default('fixed');
            $table->decimal("vatAmount")->default(0);

            $table->foreignId("createdBy")->constrained('users', 'id');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->timestamp("deletedAt")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_variants');
    }
};
