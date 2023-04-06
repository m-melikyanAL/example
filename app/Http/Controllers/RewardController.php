<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reward\BulkDeleteRewardsRequest;
use App\Http\Requests\Reward\StoreRewardRequest;
use App\Http\Requests\Reward\UpdateRewardRequest;
use App\Http\Resources\RewardResource;
use App\Models\Reward;
use App\Services\RewardService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class RewardController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $rewardQuery = Reward::query();

        if ($request->has('latest') && boolval($request->input('latest')) === true) {
            $rewardQuery->latest('id');
        }

        return RewardResource::collection($rewardQuery->paginate());
    }

    public function store(StoreRewardRequest $request, RewardService $service): RewardResource
    {
        $reward = $service->createFrom($request->validated());

        return new RewardResource($reward);
    }

    public function show(Reward $reward): RewardResource
    {
        return new RewardResource($reward);
    }

    public function update(UpdateRewardRequest $request, Reward $reward, RewardService $service): RewardResource
    {
        $reward = $service->updateWith($request->validated(), $reward);

        return new RewardResource($reward);
    }

    public function destroy(Reward $reward, RewardService $service): Response
    {
        try {
            $service->delete($reward);
        } catch (Exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    public function bulkDestroy(BulkDeleteRewardsRequest $request, RewardService $service): Response
    {
        $service->bulkDelete(collect($request->validated('rewards')));

        return response()->noContent();
    }
}
