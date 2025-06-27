<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $user_id
 * @property-read User $user
 */
class Member extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];
}
