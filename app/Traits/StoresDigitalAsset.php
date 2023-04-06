<?php

namespace App\Traits;

use App\Models\DigitalAsset;
use App\Services\DigitalAssetService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

trait StoresDigitalAsset
{
    public function storeDigitalAsset(
        FormRequest $request,
        DigitalAssetService $service,
        bool $isActive = false
    ): DigitalAsset {
        if (!in_array($request->file('asset')->extension(), ['mp4', 'pdf'])) {
            $service->resizeImage($request->file('asset'));
        }

        $path = $service->uploadAsset(
            $request->file('asset'),
            DigitalAsset::UPLOAD_FOLDER
        );

        return $service->createAssetFromPath(
            path: $path,
            isVideo: $request->file('asset')->extension() === 'mp4',
            isActive: $isActive,
            name: Str::replace(
                '.' . $request->file('asset')->extension(),
                '',
                $request->file('asset')->getClientOriginalName()
            )
        );
    }
}
