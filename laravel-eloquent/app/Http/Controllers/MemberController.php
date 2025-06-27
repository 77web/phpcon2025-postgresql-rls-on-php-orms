<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Tenancy\TenantSwitcher;
use App\Services\UseCase\GetMemberListUseCase;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

class MemberController
{
    public function all(
        AuthManager $auth,
        GetMemberListUseCase $usecase,
    ): JsonResponse {
        $tenant = $auth->guard()->user();
        assert($tenant instanceof User);

        TenantSwitcher::switchTo($tenant->email);

        return new JsonResponse($usecase->getList());
    }
}
