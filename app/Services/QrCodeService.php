<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generateCodeFrom(string $data): string
    {
        $image = QrCode::format('png')->size(300)->generate($data);
        $path = 'qr-codes/' . uniqid(Str::random(40)) . '.png';

        Storage::put($path, $image);

        return $path;
    }

    public static function getQrCodeUrl(string $path): string|null
    {
        if (!$path) {
            return null;
        }

        return Storage::url($path);
    }

    public static function deleteQrCode(string $path): void
    {
        Storage::delete($path);
    }
}
