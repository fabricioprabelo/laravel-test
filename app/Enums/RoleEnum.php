<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'Admin';
    case USER = 'User';
    case MANAGER = 'Manager';

    public function label(): string
    {
        return match ($this) {
            static::ADMIN => trans('roles.admin'),
            static::USER => trans('roles.user'),
            static::MANAGER => trans('roles.manager'),
        };
    }
}
