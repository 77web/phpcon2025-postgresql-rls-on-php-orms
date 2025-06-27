<?php

declare(strict_types=1);

namespace App\Services\UseCase;

use App\Models\Member;

class GetMemberListUseCase
{
    public function getList(): iterable
    {
        return Member::all();
    }
}
