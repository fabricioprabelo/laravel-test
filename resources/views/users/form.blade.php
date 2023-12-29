<div class="mb-4">
    <x-label for="name" value="{{ __('lang.name') }}" required />
    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', isset($user) ? $user->name : null)" required autofocus autocomplete="name" />
</div>
<div class="mb-4">
    <x-label for="email" value="{{ __('lang.email') }}" required />
    <x-input id="email" type="email" class="block mt-1 w-full" name="email" :value="old('email', isset($user) ? $user->email : null)" required autocomplete="email" />
</div>
@if (isset($user))
    <div class="mb-4">
        <x-label for="password" value="{{ __('lang.password') }}" />
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" autocomplete="off" />
    </div>
    <div class="mb-4">
        <x-label for="password_confirmation" value="{{ __('lang.confirm_password') }}" />
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" :value="old('password_confirmation')" autocomplete="off" />
    </div>
@else
    <div class="mb-4">
        <x-label for="password" value="{{ __('lang.password') }}" required />
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required autocomplete="off" />
    </div>
    <div class="mb-4">
        <x-label for="password_confirmation" value="{{ __('lang.confirm_password') }}" required />
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" :value="old('password_confirmation')" required autocomplete="off" />
    </div>
@endif
