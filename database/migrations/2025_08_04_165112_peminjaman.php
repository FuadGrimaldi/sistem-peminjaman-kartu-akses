<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam');
            $table->string('jabatan');
            $table->string('nik');
            $table->integer('durasi')->nullable();
            $table->string('lampiran')->nullable();
            $table->enum('mitra', ['Informedia', 'GSD', 'Telkom', 'ISH', 'Magang', 'PiNS']);
             $table->enum('unit', [
                'BS',
                'ES',
                'GM',
                'GOV',
                'GSD',
                'HOTDA',
                'Magang BS',
                'Magang ES',
                'Magang GOV',
                'PRQ',
                'RSO',
                'RWS',
                'SFA',
                'SSGS',
                'Blanks'
            ]);
            // Assuming 'lampiran' is a string, adjust as necessary for your use case
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'returned']);
            $table->unsignedBigInteger('requested_by_id');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->unsignedBigInteger('access_card_id')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('requested_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('access_card_id')->references('id')->on('access_cards')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
