<?php

declare(strict_types=1);

namespace App\Services\Tenancy;

use Illuminate\Support\Facades\DB;

class TenantSwitcher
{
    public static function switchTo(string $email): void
    {
        $connectionSetting = array_merge(
            config('database.connections.pgsql'),
            ['username' => $email, 'password' => $email], // TODO: danger! don't do this in prod
        );

        DB::connectUsing($email, $connectionSetting, true);
        DB::setDefaultConnection($email);
    }
}
