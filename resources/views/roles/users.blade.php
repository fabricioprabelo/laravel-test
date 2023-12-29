<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach ($users as $user)
        <label class="flex items-center">
            <x-checkbox name="users[]" :value="$user->id" :checked="in_array($user->id, isset($role) ? $role->selected_users: [])" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $user->name }}</span>
        </label>
    @endforeach
</div>
