<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('menu_items')->update([
            'price' => DB::raw('price * 4000')
        ]);
        
        DB::table('menu_item_prices')->update([
            'price' => DB::raw('price * 4000')
        ]);

        DB::table('orders')->update([
            'subtotal' => DB::raw('subtotal * 4000'),
            'total' => DB::raw('total * 4000')
        ]);

        DB::table('order_items')->update([
            'price' => DB::raw('price * 4000'),
            'subtotal' => DB::raw('subtotal * 4000')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('menu_items')->update([
            'price' => DB::raw('price / 4000')
        ]);
        
        DB::table('menu_item_prices')->update([
            'price' => DB::raw('price / 4000')
        ]);

        DB::table('orders')->update([
            'subtotal' => DB::raw('subtotal / 4000'),
            'total' => DB::raw('total / 4000')
        ]);

        DB::table('order_items')->update([
            'price' => DB::raw('price / 4000'),
            'subtotal' => DB::raw('subtotal / 4000')
        ]);
    }
};
