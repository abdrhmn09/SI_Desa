<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoLinkModel extends Model
{
    protected $table          = 'video_link';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ['judul', 'deskripsi', 'url_video'];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    /**
     * Konversi URL YouTube & TikTok biasa → URL embed.
     */
    public static function toEmbedUrl(string $url): string
    {
        // Cek YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // Cek TikTok (Format: https://www.tiktok.com/@username/video/1234567890)
        if (preg_match('/tiktok\.com\/@[^\/]+\/video\/(\d+)/', $url, $m)) {
            return 'https://www.tiktok.com/player/v1/' . $m[1] . '?&autoplay=0';
        }

        // Jika sudah embed URL atau platform lain, kembalikan apa adanya
        return $url;
    }
}
