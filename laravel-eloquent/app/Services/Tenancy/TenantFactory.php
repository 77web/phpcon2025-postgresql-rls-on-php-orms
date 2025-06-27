<?php

declare(strict_types=1);

namespace App\Services\Tenancy;

use App\Models\User;
use Illuminate\Database\DatabaseManager;

class TenantFactory
{
    public function __construct(
        private DatabaseManager $databaseManager
    ) {
    }

    public function create(string $email): User
    {
        $user = new User();
        $user->email = $email;
        $user->name = $email;
        $user->password = bcrypt('password');
        $user->save();

        $conn = $this->databaseManager->connection();

        $conn->statement(sprintf('CREATE ROLE "%s" LOGIN', $user->email));
        $conn->statement(sprintf('ALTER ROLE "%s" WITH PASSWORD \'%s\'', $user->email, $user->email)); // TODO danger! don't do this in prod
        $conn->statement(sprintf('GRANT tenant to "%s"', $user->email));

        return $user;
    }
}
