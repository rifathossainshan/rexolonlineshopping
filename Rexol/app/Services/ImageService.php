<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        // Use GD Driver by default
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload and optimize an image.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param int|null $width
     * @param int|null $height
     * @return string Relative path to storage
     */
    public function upload(UploadedFile $file, string $path = 'uploads', ?int $width = 800, ?int $height = null): string
    {
        $filename = Str::uuid() . '.webp'; // Convert to WebP for optimization
        $fullPath = $path . '/' . $filename;

        $image = $this->manager->read($file);

        // Resize if width is provided (aspect ratio maintained if height is null)
        if ($width) {
            $image->scale(width: $width, height: $height);
        }

        // Encode to WebP with 80% quality
        $encoded = $image->toWebp(quality: 80);

        // Store to public disk
        Storage::disk('public')->put($fullPath, (string) $encoded);

        return $fullPath;
    }
}
