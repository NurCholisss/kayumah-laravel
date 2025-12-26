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
        // Ubah enum order_status ke status Indonesia
        DB::statement("ALTER TABLE `orders` MODIFY `order_status` ENUM('menunggu','disetujui','dikirim','pesanan diterima','ditolak','cancelled') NOT NULL DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan ke enum sebelumnya
        DB::statement("ALTER TABLE `orders` MODIFY `order_status` ENUM('pending','processed','shipped','completed','rejected','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
