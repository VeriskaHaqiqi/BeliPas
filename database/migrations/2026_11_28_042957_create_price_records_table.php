<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commodity_id')
                ->constrained('commodities')
                ->restrictOnDelete();

            $table->foreignId('market_id')
                ->constrained('markets')
                ->restrictOnDelete();

            $table->date('price_date');
            $table->decimal('price', 14, 2);
            $table->string('source_name', 150);

            $table->foreignId('data_import_id')
                ->nullable()
                ->constrained('data_imports')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(
                ['commodity_id', 'market_id', 'price_date'],
                'price_records_unique_daily_price'
            );

            $table->index(
                ['market_id', 'price_date'],
                'price_records_market_date_idx'
            );
        });
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement(
                'ALTER TABLE price_records
                ADD CONSTRAINT price_records_price_positive
                CHECK (price > 0)'
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('price_records');
    }
};
