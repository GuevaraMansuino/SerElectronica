<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Products table
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('slug')->unique();
        });

        // Categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('slug')->unique();
        });

        // Promotions table
        Schema::table('promotions', function (Blueprint $table) {
            $table->index('is_active');
            $table->index(['start_date', 'end_date']);
        });

        // Product promotion pivot
        Schema::table('product_promotion', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('promotion_id');
        });

        // Category promotion pivot
        Schema::table('category_promotion', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('promotion_id');
        });

        // Users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('email')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['slug']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['start_date', 'end_date']);
        });

        Schema::table('product_promotion', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['promotion_id']);
        });

        Schema::table('category_promotion', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['promotion_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });
    }
};
