<div class="mb-4">
    <x-label for="name" value="{{ __('lang.name') }}" required />
    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', isset($role) ? $role->name : null)" required autofocus autocomplete="name" />
</div>
