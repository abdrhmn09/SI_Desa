<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Menambahkan Foreign Key kepala_keluarga_id → penduduk.id
 * pada tabel kartu_keluarga.
 *
 * Migration ini terpisah dari CreateKartuKeluargaTable karena adanya
 * circular dependency: kartu_keluarga.kepala_keluarga_id → penduduk.id,
 * sementara penduduk.kartu_keluarga_id → kartu_keluarga.id.
 * Solusinya: buat kedua tabel dulu tanpa FK melingkar, baru tambahkan FK ini
 * setelah tabel penduduk sudah ada.
 */
class AddFkKepalaKeluargaToPenduduk extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey(
            'kepala_keluarga_id',   // kolom di kartu_keluarga
            'penduduk',             // tabel referensi
            'id',                   // kolom referensi
            'SET NULL',             // ON UPDATE
            'SET NULL'              // ON DELETE: jika penduduk dihapus, kepala_keluarga_id jadi NULL
        );

        $this->forge->processIndexes('kartu_keluarga');
    }

    public function down()
    {
        $this->forge->dropForeignKey('kartu_keluarga', 'kartu_keluarga_kepala_keluarga_id_foreign');
    }
}
