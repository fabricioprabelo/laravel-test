<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case USER_LIST = 'users:list';
    case USER_CREATE = 'users:create';
    case USER_UPDATE = 'users:update';
    case USER_DELETE = 'users:delete';

    case ROLE_LIST = 'roles:list';
    case ROLE_CREATE = 'roles:create';
    case ROLE_UPDATE = 'roles:update';
    case ROLE_DELETE = 'roles:delete';

    case TEAM_LIST = 'teams:list';
    case TEAM_CREATE = 'teams:create';
    case TEAM_UPDATE = 'teams:update';
    case TEAM_DELETE = 'teams:delete';

    case HOTEL_LIST = 'hotels:list';
    case HOTEL_CREATE = 'hotels:create';
    case HOTEL_UPDATE = 'hotels:update';
    case HOTEL_DELETE = 'hotels:delete';

    public function label(): string
    {
        return match ($this) {
            static::USER_LIST => trans('permissions.users-list'),
            static::USER_CREATE => trans('permissions.users-create'),
            static::USER_UPDATE => trans('permissions.users-update'),
            static::USER_DELETE => trans('permissions.users-delete'),

            static::ROLE_LIST => trans('permissions.roles-list'),
            static::ROLE_CREATE => trans('permissions.roles-create'),
            static::ROLE_UPDATE => trans('permissions.roles-update'),
            static::ROLE_DELETE => trans('permissions.roles-delete'),

            static::TEAM_LIST => trans('permissions.teams-list'),
            static::TEAM_CREATE => trans('permissions.teams-create'),
            static::TEAM_UPDATE => trans('permissions.teams-update'),
            static::TEAM_DELETE => trans('permissions.teams-delete'),

            static::HOTEL_LIST => trans('permissions.hotels-list'),
            static::HOTEL_CREATE => trans('permissions.hotels-create'),
            static::HOTEL_UPDATE => trans('permissions.hotels-update'),
            static::HOTEL_DELETE => trans('permissions.hotels-delete'),
        };
    }
}
