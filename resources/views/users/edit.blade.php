@section('title', __('lang.edit_arg', ['arg' => strtolower(__('lang.user'))]))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('lang.edit_arg', ['arg' => strtolower(__('lang.user'))]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                        <li class="me-2">
                            <button id="user-tab" data-tabs-target="#user" type="button" role="tab" aria-controls="about" aria-selected="true" class="inline-block p-4 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">{{ __('lang.user') }}</button>
                        </li>
                        <li class="me-2">
                            <button id="roles-tab" data-tabs-target="#roles" type="button" role="tab" aria-controls="services" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">{{ __('lang.roles') }}</button>
                        </li>
                        <li class="me-2">
                            <button id="permissions-tab" data-tabs-target="#permissions" type="button" role="tab" aria-controls="services" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">{{ __('lang.permissions') }}</button>
                        </li>
                    </ul>
                    <div id="defaultTabContent" class="py-0">
                        <div class="hidden p-4 bg-white rounded-lg md:px-8 md:pt-8 dark:bg-gray-800" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <x-validation-errors class="mb-4" />
                            @include('users.form', ['user' => $user])
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg md:px-8 md:pt-8 dark:bg-gray-800" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                            <x-validation-errors class="mb-4" />
                            @include('users.roles', ['user' => $user, 'roles' => $roles])
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg md:px-8 md:pt-8 dark:bg-gray-800" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                            <x-validation-errors class="mb-4" />
                            @include('users.permissions', ['user' => $user, 'permissions' => $permissions])
                        </div>
                    </div>
                    <div class="relative overflow-x-auto p-4 mt-4 md:mt-8 border-t">
                        <div class="flex">
                            <x-button>
                                {{ __('lang.save_arg', ['arg' => strtolower(__('lang.user'))]) }}
                            </x-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
