<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\BulkDeleteDiscountsRequest;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use App\Services\DiscountService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DiscountController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $discountQuery = Discount::query();

        if ($request->has('latest') && boolval($request->input('latest')) === true) {
            $discountQuery->latest();
        }

        if ($request->has('status') && $request->input('status')) {
            $request->input('status') === Discount::STATUS_ACTIVE
                ? $discountQuery->where('status', Discount::STATUS_ACTIVE)
                : $discountQuery->where('status', Discount::STATUS_INACTIVE);
        }

        if ($request->has('current') && boolval($request->input('current')) === true) {
            $currentDateTime = now()->toDateString();
            $discountQuery->where(function ($query) use ($currentDateTime) {
                $query->where('started_at', '<=', $currentDateTime)
                    ->orWhereNull('started_at', null);
            });
            $discountQuery->where(function ($query) use ($currentDateTime) {
                $query->where('ended_at', '>=', $currentDateTime)
                    ->orWhereNull('ended_at', null);
            });
        }

        return DiscountResource::collection($discountQuery->paginate());
    }

    public function store(StoreDiscountRequest $request, DiscountService $service): DiscountResource
    {
        $discount = $service->createFrom($request->validated());

        return new DiscountResource($discount);
    }

    public function show(Discount $discount): DiscountResource
    {
        return new DiscountResource($discount);
    }

    public function update(
        UpdateDiscountRequest $request,
        Discount $discount,
        DiscountService $service
    ): DiscountResource {
        $discount = $service->updateWith($request->validated(), $discount);

        return new DiscountResource($discount);
    }

    public function destroy(Discount $discount, DiscountService $service): Response
    {
        try {
            $service->delete($discount);
        } catch (Exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    public function bulkDestroy(BulkDeleteDiscountsRequest $request, DiscountService $service): Response
    {
        $service->bulkDelete(collect($request->validated('discounts')));

        return response()->noContent();
    }
}
