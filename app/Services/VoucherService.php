<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class VoucherService
{
    public function createFor(array $data): Voucher
    {
        $voucher = Voucher::create([
            'phone_country_code' => Arr::get($data, 'phone_country_code'),
            'phone_number' => Arr::get($data, 'phone_number'),
            'room_number' => Arr::get($data, 'room_number'),
            'first_name' => Arr::get($data, 'first_name'),
            'last_name' => Arr::get($data, 'last_name'),
            'title' => Arr::get($data, 'title'),
            'type' => Arr::get($data, 'type'),
            'value' => Arr::get($data, 'value'),
            'is_percentage' => Arr::get($data, 'is_percentage', false),
            'description' => Arr::get($data, 'description'),
            'approved_by' => Auth::user()->id,
            'expires_at' => Arr::get($data, 'expires_at')
                ? Carbon::parse(Arr::get($data, 'expires_at'))->endOfDay()
                : null,
        ]);

        if (Arr::has($data, 'tags')) {
            $this->setVoucherTags($voucher, Arr::get($data, 'tags'));
        }

        return $voucher;
    }

    public function updateWith(array $data, Voucher $voucher): Voucher
    {
        $voucher->fill([
            'title' => Arr::get($data, 'title', $voucher->title),
            'value' => Arr::get($data, 'value', $voucher->value),
            'is_percentage' => Arr::get($data, 'is_percentage', $voucher->is_percentage),
            'expires_at' => Carbon::parse(
                Arr::get($data, 'expires_at', $voucher->expires_at)
            )->endOfDay(),
        ]);

        if (Arr::has($data, 'tags')) {
            $this->setVoucherTags($voucher, Arr::get($data, 'tags'));
        }

        $voucher->save();

        return $voucher;
    }

    public function delete(Voucher $voucher): void
    {
        /** @var QrCodeService $qrCodeService */
        $qrCodeService = app(QrCodeService::class);

        $qrCodeService->deleteQrCode($voucher->qr_image_path);

        $voucher->delete();
    }

    private function setVoucherTags(Voucher $voucher, array $tags): void
    {
        $voucher->tags()->detach();
        $tags = collect($tags);
        $tags = $tags->map(
            fn (string $tag) => Tag::firstOrCreate(
                [
                    'name' => $tag,
                    'is_active' => true,
                ]
            )
        );
        $voucher->tags()->saveMany($tags);
    }

    public function createQrFor(Voucher $voucher): void
    {
        /** @var QrCodeService $qrCodeService */
        $qrCodeService = app(QrCodeService::class);

        $approvedBy = $voucher->relationLoaded('approver') ? $voucher->approver?->name : '';
        $tags = $voucher->relationLoaded('tags') ? $voucher->tags?->pluck('name') : [];

        $voucherData = [
            'title' => $voucher->title,
            'value' => $voucher->value,
            'type' => $voucher->type,
            'approved_by' => $approvedBy,
            'phone_number' => $voucher->phone_number,
            'phone_country_code' => $voucher->phone_country_code,
            'booking_id' => $voucher->booking_id,
            'booking_room_id' => $voucher->booking_room_id,
            'expires_at' => $voucher->expires_at?->format(config('crm.short_date_format')),
            'room_number' => $voucher->room_number,
            'tags' => $tags,
        ];

        if ($voucher->qr_image_path) {
            $qrCodeService->deleteQrCode($voucher->qr_image_path);
        }

        $qrCodePath = $qrCodeService->generateCodeFrom(json_encode($voucherData));

        $voucher->qr_image_path = $qrCodePath;
        $voucher->save();
    }

    public function bulkDelete(Collection $vouchers): void
    {
        $vouchers->each(function ($voucher) {
            $this->delete($voucher);
        });
    }
}
