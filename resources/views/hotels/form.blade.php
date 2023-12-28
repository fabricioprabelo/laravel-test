<div class="mb-4">
    <x-label for="name" value="{{ __('Name') }}" />
    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', isset($hotel) ? $hotel->name : null)" required autofocus autocomplete="name" />
</div>
<div class="mb-4">
    <x-label for="zip_code" value="{{ __('CEP') }}" />
    <x-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code', isset($hotel) ? $hotel->zip_code : null)" maxlength="9" required autocomplete="zip_code" data-inputmask="'mask': '99999-999'" />
</div>
<div class="mb-4">
    <x-label for="address" value="{{ __('Address') }}" />
    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', isset($hotel) ? $hotel->address : null)" required autocomplete="address" />
</div>
<div class="mb-4">
    <x-label for="complement" value="{{ __('Complement') }}" />
    <x-input id="complement" class="block mt-1 w-full" type="text" name="complement" :value="old('complement', isset($hotel) ? $hotel->complement : null)" autocomplete="complement" />
</div>
<div class="mb-4">
    <x-label for="neighborhood" value="{{ __('Neighborhood') }}" />
    <x-input id="neighborhood" class="block mt-1 w-full" type="text" name="neighborhood" :value="old('neighborhood', isset($hotel) ? $hotel->neighborhood : null)" autocomplete="neighborhood" />
</div>
<div class="mb-4">
    <x-label for="city" value="{{ __('City') }}" />
    <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', isset($hotel) ? $hotel->city : null)" required autocomplete="city" />
</div>
<div class="mb-4">
    <x-label for="state" value="{{ __('State') }}" />
    <x-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state', isset($hotel) ? $hotel->state : null)" required autocomplete="state" />
</div>
<div class="mb-4">
    <x-label for="website" value="{{ __('Website') }}" />
    <x-input id="website" class="block mt-1 w-full" type="text" name="website" :value="old('website', isset($hotel) ? $hotel->website : null)" autocomplete="website" />
</div>
