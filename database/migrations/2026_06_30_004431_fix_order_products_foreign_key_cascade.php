<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Corrige el foreign key de order_id en order_products:
     * de nullOnDelete() (que causaba error NOT NULL) a cascadeOnDelete()
     * para que al borrar una orden se borren sus productos automáticamente.
     */
    public function up(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            // Eliminar el foreign key anterior
            $table->dropForeign(['order_id']);

            // Recrear con CASCADE para que al eliminar la orden
            // se eliminen sus order_products automáticamente
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropForeign(['order_id']);

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->nullOnDelete();
        });
    }
};
