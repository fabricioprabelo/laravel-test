<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach ($roles as $role)
        <label class="flex items-center">
            <x-checkbox name="roles[]" :value="$role->name" :checked="in_array($role->name, isset($user) ? $user->selected_roles: [])" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $role->name }}</span>
        </label>
    @endforeach
</div>
