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
        Schema::create('products', function (Blueprint $table) {
            $table->id("productId");
            $table->uuid()->index();
            $table->string('name');
            $table->string('slug')->index()->nullable();
            $table->foreignId('categoryId')
                ->unique()->index()
                ->constrained('categories', 'categoryId');
            $table->foreignId('brandId')
                ->unique()->index()
                ->constrained('brands', 'brandId');
            $table->foreignId('unitId')
                ->unique()->index()
                ->constrained('units', 'unitId');
            $table->decimal('basePrice')->default(0);
            $table->enum('discountType', ['fixed', 'percent'])->default('fixed');
            $table->decimal('discountAmount')->default(0);
            $table->enum('vatType', ['fixed', 'percent'])->default('fixed');
            $table->decimal('vatAmount')->default(0);
            $table->text('description')->nullable();
            $table->string('imageUrl')->nullable();
            $table->boolean('isActive')->default(true);
            $table->foreignId('createdBy')
                ->constrained('users', 'id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
