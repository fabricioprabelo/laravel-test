<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelRole;

class Role extends ModelRole
{
    use HasFactory;

    public function selectedUsers()
    {
        $selected_users = [];
        foreach($this->users as $user) {
            $selected_users[] = $user->id;
        }
        return $selected_users;
    }

    public function selectedPermissions()
    {
        $selected_permissions = [];
        foreach($this->permissions as $permission) {
            $selected_permissions[] = $permission->name;
        }
        return $selected_permissions;
    }
}
