<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach ($permissions as $permission)
        <label class="flex items-center">
            <x-checkbox name="permissions[]" :value="$permission->name" :checked="in_array($permission->name, isset($role) ? $role->selected_permissions: [])" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('permissions.' . str_replace(':', '-', $permission->name)) }}</span>
        </label>
    @endforeach
</div>
