<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update status lama ke status baru terlebih dahulu
        DB::table('orders')->where('order_status', 'pending')->update(['order_status' => 'menunggu']);
        DB::table('orders')->where('order_status', 'processed')->update(['order_status' => 'disetujui']);
        DB::table('orders')->where('order_status', 'shipped')->update(['order_status' => 'dikirim']);
        DB::table('orders')->where('order_status', 'completed')->update(['order_status' => 'pesanan diterima']);
        
        // Kemudian ubah enum
        DB::statement("ALTER TABLE `orders` MODIFY `order_status` ENUM('menunggu','disetujui','dikirim','pesanan diterima','ditolak','cancelled') NOT NULL DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Update status baru ke status lama
        DB::table('orders')->where('order_status', 'menunggu')->update(['order_status' => 'pending']);
        DB::table('orders')->where('order_status', 'disetujui')->update(['order_status' => 'processed']);
        DB::table('orders')->where('order_status', 'dikirim')->update(['order_status' => 'shipped']);
        DB::table('orders')->where('order_status', 'pesanan diterima')->update(['order_status' => 'completed']);
        
        // Kembalikan enum
        DB::statement("ALTER TABLE `orders` MODIFY `order_status` ENUM('pending','processed','shipped','completed','rejected','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
