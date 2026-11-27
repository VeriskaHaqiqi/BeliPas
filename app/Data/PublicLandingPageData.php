<?php

namespace App\Data;

final class PublicLandingPageData
{
    public static function content(): array
    {
        return [
            'problems' => [
                ['icon' => 'landing-problem-01.svg', 'title' => 'Harga bahan baku berubah', 'copy' => 'Perubahan harga dapat memengaruhi perhitungan biaya menu dan kebutuhan belanja usaha.', 'impact' => 'Perlu memperbarui rencana belanja'],
                ['icon' => 'landing-problem-02.svg', 'title' => 'Keputusan hanya berdasarkan kebiasaan', 'copy' => 'Tanpa ringkasan tren, menentukan waktu dan jumlah pembelian terasa lebih sulit.', 'impact' => 'Risiko stok berlebih atau kurang'],
                ['icon' => 'landing-problem-03.svg', 'title' => 'Sulit membandingkan informasi pasar', 'copy' => 'Mencari informasi harga dari banyak sumber menyita waktu operasional.', 'impact' => 'Waktu untuk mengelola usaha berkurang'],
            ],
            'steps' => [
                ['title' => 'Cek harga komoditas', 'copy' => 'Lihat ringkasan harga, satuan, pasar acuan, serta pembaruan data yang tersedia.', 'detail' => 'Informasi harga terpusat'],
                ['title' => 'Pahami estimasi dan sinyal', 'copy' => 'Baca arah perkiraan harga 1–7 hari beserta BUY NOW, WAIT, atau MONITOR.', 'detail' => 'Bahasa visual yang ringkas'],
                ['title' => 'Sesuaikan rencana belanja', 'copy' => 'Gunakan informasi tersebut sebagai bahan pertimbangan bersama stok dan kebutuhan usaha.', 'detail' => 'Keputusan tetap di tangan Anda'],
            ],
            'signals' => [
                ['signal' => 'BUY NOW', 'icon' => 'landing-signal-01.svg', 'title' => 'Pertimbangkan beli sekarang', 'copy' => 'Estimasi menunjukkan harga dapat naik. Pertimbangkan kebutuhan stok tanpa membeli melebihi kapasitas usaha.', 'action' => 'Sesuaikan dengan kebutuhan stok'],
                ['signal' => 'WAIT', 'icon' => 'landing-signal-02.svg', 'title' => 'Pertimbangkan menunggu', 'copy' => 'Estimasi menunjukkan harga dapat turun. Bila stok masih cukup, Anda dapat meninjau kembali waktu pembelian.', 'action' => 'Pantau kembali perkembangannya'],
                ['signal' => 'MONITOR', 'icon' => 'landing-signal-03.svg', 'title' => 'Pantau dan beli sesuai kebutuhan', 'copy' => 'Perkiraan belum menunjukkan perubahan yang kuat. Rencanakan pembelian seperti biasa sambil memeriksa pembaruan.', 'action' => 'Belanja mengikuti kebutuhan'],
            ],
            'categories' => [
                ['id' => 'cabai-rawit-merah', 'icon' => 'landing-commodity-02.svg', 'title' => 'Cabai', 'detail' => 'Cabai rawit merah', 'status' => 'DATA DEMO'],
                ['id' => 'daging-ayam-broiler', 'icon' => 'landing-commodity-03.svg', 'title' => 'Daging Ayam', 'detail' => 'Ayam broiler', 'status' => 'DATA DEMO'],
                ['id' => 'telur-ayam-ras', 'icon' => 'landing-commodity-04.svg', 'title' => 'Telur Ayam', 'detail' => 'Telur ayam ras', 'status' => 'DATA DEMO'],
                ['id' => 'bawang-merah-brebes', 'icon' => 'landing-commodity-05.svg', 'title' => 'Bawang Merah', 'detail' => 'Bawang merah Brebes', 'status' => 'DATA DEMO'],
                ['id' => 'minyak-goreng-curah', 'icon' => 'landing-commodity-06.svg', 'title' => 'Minyak Goreng', 'detail' => 'Minyak goreng curah', 'status' => 'DATA DEMO'],
            ],
        ];
    }
}
