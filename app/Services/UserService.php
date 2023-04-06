<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createWith(array $data): User
    {
        return User::create([
            'username' => Arr::get($data, 'username'),
            'name' => Arr::get($data, 'name'),
            'last_name' => Arr::get($data, 'last_name'),
            'email' => Arr::get($data, 'email'),
            'phone_number' => Arr::get($data, 'phone_number'),
            'phone_country_code' => Arr::get($data, 'phone_country_code'),
            'password' => Hash::make(Arr::get($data, 'password')),
        ]);
    }

    public function updateWith(array $data, User $user): User
    {
        if (Arr::has($data, 'password') && Arr::get($data, 'password')) {
            Arr::set(
                $data,
                'password',
                Hash::make(Arr::get($data, 'password'))
            );
        }

        if (Arr::get($data, 'password') === null) {
            unset($data['password']);
        }

        if (Arr::get($data, 'role')) {
            $user->syncRoles(Arr::get($data, 'role'));
        }

        $user->fill($data);

        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function bulkDelete(Collection $userIds): void
    {
        User::destroy($userIds);
    }
}
