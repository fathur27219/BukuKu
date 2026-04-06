<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();

        // sementara JANGAN pakai constrained dulu
        $table->unsignedBigInteger('member_id');
        $table->unsignedBigInteger('book_id');

        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali');
        $table->date('tanggal_dikembalikan')->nullable();

        $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
        $table->integer('denda')->default(0);

        $table->timestamps();
     });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
