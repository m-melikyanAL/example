<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\BulkDeleteVouchersRequest;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class VoucherController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $voucherQuery = Voucher::with(['tags', 'approver'])
            ->where(function ($query) {
                $query->where('expires_at', '>=', now())
                    ->orWhereNull('expires_at');
            });

        if ($request->has('latest') && boolval($request->input('latest')) === true) {
            $voucherQuery->latest('id');
        }

        return VoucherResource::collection($voucherQuery->paginate());
    }

    public function show(Voucher $voucher): VoucherResource
    {
        $voucher->load(['tags', 'approver']);

        return new VoucherResource($voucher);
    }

    public function store(StoreVoucherRequest $request, VoucherService $service): VoucherResource
    {
        $voucher = $service->createFor($request->validated());

        $voucher = $voucher->fresh(['tags', 'approver']);

        $service->createQrFor($voucher);

        return new VoucherResource($voucher);
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher, VoucherService $service): VoucherResource
    {
        $voucher = $service->updateWith($request->validated(), $voucher);

        $voucher = $voucher->fresh(['tags', 'approver']);

        $service->createQrFor($voucher);

        return new VoucherResource($voucher);
    }

    public function destroy(Voucher $voucher, VoucherService $service): Response
    {
        $service->delete($voucher);

        return response()->noContent();
    }

    public function bulkDestroy(BulkDeleteVouchersRequest $request, VoucherService $service): Response
    {
        $service->bulkDelete(
            Voucher::whereIn('id', $request->validated('vouchers'))->get()
        );

        return response()->noContent();
    }
}
