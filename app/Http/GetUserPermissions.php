<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class GetUserPermissions
{
    public function run(string $userId): array
    {
        $user = User::with([
            'permissions' => function ($query) {
                $query->get(['uuid', 'name']);
            },
        ])->findOrFail($userId);

        //if has direct permissions use it
        if ($user->permissions->count()) {
            return $this->mapPermissions($user->permissions);
        }

        //get the permissions via roles
        return $this->mapPermissions($user->getAllPermissions());
    }

    private function mapPermissions(Collection $permissions): array
    {
        return $permissions->map(fn ($permission) => [
            'id' => $permission->uuid,
            'name' => $permission->name,
        ])->toArray();
    }
}
