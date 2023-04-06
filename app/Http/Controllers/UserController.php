<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\BulkDeleteUsersRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UserController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $userQuery = User::query();

        $userQuery->with('roles');

        $userQuery->latest('id');

        $userQuery = $this->applySearchFilter($request, $userQuery);

        return UserResource::collection($userQuery->paginate())
            ->additional([
                'roles' => Role::pluck('name'),
            ]);
    }

    public function store(StoreUserRequest $request, UserService $service): UserResource
    {
        $user = $service->createWith($request->validated());

        $user = $user->fresh('roles');

        return UserResource::make($user);
    }

    public function show(User $user): UserResource
    {
        $user->load('roles');

        return UserResource::make($user)
            ->additional([
                'roles' => Role::pluck('name'),
            ]);
    }

    public function update(UpdateUserRequest $request, User $user, UserService $service): UserResource
    {
        $user = $service->updateWith($request->validated(), $user);

        $user = $user->fresh('roles');

        return UserResource::make($user)
            ->additional([
                'roles' => Role::pluck('name'),
            ]);
    }

    public function destroy(User $user, UserService $service): Response
    {
        $service->delete($user);

        return response()->noContent();
    }

    public function bulkDestroy(BulkDeleteUsersRequest $request, UserService $service): Response
    {
        $service->bulkDelete(
            collect($request->validated('users'))
        );

        return response()->noContent();
    }

    private function applySearchFilter(Request $request, Builder $query): Builder
    {
        if (!$request->has('search_filter')) {
            return $query;
        }

        if (!$request->input('search_filter')) {
            return $query;
        }

        return $query->where(
            'name',
            'like',
            '%' . $request->input('search_filter') . '%'
        )
            ->orWhere(
                'last_name',
                'like',
                '%' . $request->input('search_filter') . '%'
            )
            ->orWhere(
                'email',
                'like',
                '%' . $request->input('search_filter') . '%'
            );
    }
}
