<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IdentitasDesaSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            'nama_desa'        => 'Blang Kubu',
            'kode_desa'        => null, // Tidak disebutkan dalam dokumen
            'nama_kepala_desa' => 'Marhadi',
            'nip_kepala_desa'  => null, // Tidak disebutkan dalam dokumen
            'alamat_kantor'    => 'Gampong Blang Kubu, Kec. Peudada, Kab. Bireuen',
            'logo'             => 'logoDesa.png',
            'provinsi'         => 'Aceh',
            'kabupaten'        => 'Bireuen',
            'kecamatan'        => 'Peudada',
            'kodepos'          => null,
            
            // Kolom dari AddProfilToIdentitasDesa
            'sejarah'          => 'Nama Gampong Blang Kubu terdiri dari dua suku kata yaitu Blang yang artinya Sawah dan Kubu yang artinya tempat pertahanan perang.maka oleh peutua Gampong pada saat itu mengambil suatu kebijakan untuk mendeklarasikan sebuah nama gampong di ambil dari peta pertahanan yang berada di tengah persawahan pada saat itu yaitu Kubu sawah maka Gampong Blang Kubu menjadi terkenal saat itu karena wilayahnya yang sangat luas dan penduduknya yang begitu padat hingga terjadi dua kali pemekaran Yaitu Gampong Calok dan Gampong Neubok Naleung yang dulunya merupakan Dusun dari Gampong Blang Kubu. Gampong Blang Kubu merupakan salah satu Gampong yang terletak di Kemukiman Batee Kureng Kecamatan Peudada Kabupaten Bireuen yang terbagi dalam 3 ( Tiga ) buah dusun yaitu Dusun Kuta Harapan, Dusun Putroe Labu dan Dusun Jrat Manyang, manyoritas penduduk Gampong Blang Kubu bermata pencaharian sebagai Nelayan, Pekebun, Petani dan sebagian lainnya sebagai pedagang dan pegawai negeri',
            'visi_misi'        => null, // Tidak disebutkan dalam dokumen
            'geografis'        => 'Terletak di pinggiran Jalan Negara Kecamatan Peudada dengan jarak 1,5 KM dari pusat kecamatan. Luas wilayah mencapai 740 Ha yang terdiri atas area pemukiman, tambak, dan kebun. Berbatasan dengan Gampong Neubok Naleung dan Selat Malaka (Utara), Gampong Mns. Garot (Selatan), Gampong Pulo (Timur), dan Gampong Sawang (Barat).',
            'demografi'        => 'Penduduk berjumlah 1.208 jiwa dan 308 KK yang terbagi ke dalam 3 Dusun (Kuta Harapan, Putroe Labu, dan Jrat Manyang). Mayoritas penduduk bermata pencaharian sebagai nelayan, pekebun, dan petani tambak.',
            'email'            => null,
            'telepon'          => null,
            'facebook'         => null,
            'instagram'        => null,
            'youtube'          => null,
            'twitter'          => null,
            'embed_peta'       => null,

            'created_at'       => $now,
            'updated_at'       => $now,
        ];

        // Kosongkan tabel terlebih dahulu untuk menghindari penumpukan data identitas (Opsional)
        // $this->db->table('identitas_desa')->truncate();

        // Masukkan data ke dalam tabel identitas_desa
        $this->db->table('identitas_desa')->insert($data);
    }
}