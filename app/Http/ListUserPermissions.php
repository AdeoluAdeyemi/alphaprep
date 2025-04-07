<?php

namespace App\Http\Services;

use Illuminate\Support\Arr;

class ListUserPermissions
{
    public function run(string $userId): array
    {
        $userPermissions = (new GetUserPermissions())->run($userId);

        return Arr::pluck($userPermissions, 'name');
    }
}
