<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the first image URL from a gambar field that may be:
     * - A JSON array of file paths
     * - A single file path
     * - A base64 string
     * - null
     */
    public static function getFirstImage($gambar)
    {
        if (empty($gambar)) return '';
        
        // Try JSON decode
        $decoded = json_decode($gambar, true);
        
        if (is_array($decoded) && count($decoded) > 0) {
            $first = $decoded[0];
            return str_starts_with($first, 'data:') ? $first : asset('storage/' . $first);
        }
        
        // Single value (legacy)
        return str_starts_with($gambar, 'data:') ? $gambar : asset('storage/' . $gambar);
    }
    
    /**
     * Get all image URLs from a gambar field
     */
    public static function getAllImages($gambar)
    {
        if (empty($gambar)) return [];
        
        $decoded = json_decode($gambar, true);
        
        if (is_array($decoded)) {
            return array_map(function($img) {
                return str_starts_with($img, 'data:') ? $img : asset('storage/' . $img);
            }, $decoded);
        }
        
        // Single value (legacy)
        $url = str_starts_with($gambar, 'data:') ? $gambar : asset('storage/' . $gambar);
        return [$url];
    }
}
