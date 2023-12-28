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

    case HOTEL_LIST = 'hotels:list';
    case HOTEL_CREATE = 'hotels:create';
    case HOTEL_UPDATE = 'hotels:update';
    case HOTEL_DELETE = 'hotels:delete';

    case ROOM_LIST = 'rooms:list';
    case ROOM_CREATE = 'rooms:create';
    case ROOM_UPDATE = 'rooms:update';
    case ROOM_DELETE = 'rooms:delete';

    public function label(): string
    {
        return match ($this) {
            static::USER_LIST => trans('permissions.user-list'),
            static::USER_CREATE => trans('permissions.user-create'),
            static::USER_UPDATE => trans('permissions.user-update'),
            static::USER_DELETE => trans('permissions.user-delete'),

            static::ROLE_LIST => trans('permissions.role-list'),
            static::ROLE_CREATE => trans('permissions.role-create'),
            static::ROLE_UPDATE => trans('permissions.role-update'),
            static::ROLE_DELETE => trans('permissions.role-delete'),

            static::HOTEL_LIST => trans('permissions.hotel-list'),
            static::HOTEL_CREATE => trans('permissions.hotel-create'),
            static::HOTEL_UPDATE => trans('permissions.hotel-update'),
            static::HOTEL_DELETE => trans('permissions.hotel-delete'),

            static::ROOM_LIST => trans('permissions.room-list'),
            static::ROOM_CREATE => trans('permissions.room-create'),
            static::ROOM_UPDATE => trans('permissions.room-update'),
            static::ROOM_DELETE => trans('permissions.room-delete'),
        };
    }
}
