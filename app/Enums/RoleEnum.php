<?php

namespace App\Enums;

enum RoleEnum: string
{

    case ADMIN = 'Admin';
    case USER = 'User';

    public function label(): string
    {
        return match ($this) {
            static::ADMIN => trans('role.admin'),
            static::USER => trans('role.user'),
        };
    }
}
