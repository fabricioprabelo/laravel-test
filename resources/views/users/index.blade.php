@section('title', __('lang.users'))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('lang.list_arg', ['arg' => strtolower(__('lang.users'))]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @can('users:create')
                        <x-link href="{{ route('users.create') }}" class="m-4">{{__('lang.add_arg', ['arg' => strtolower(__('lang.user'))])}}</x-link>
                    @endcan
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ __('lang.user') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('lang.email') }}
                            </th>
                            <th scope="col" class="flex px-6 py-3 justify-center items-center">
                                <x-heroicon-o-bolt class="w-4 h-4 text-gray-500 dark:text-gray-200" />
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 w-44 items-center">
                                    @can('users:update')
                                    <x-tooltip id="tooltip-edit-{{$user->id}}">
                                        <x-slot:content>{{ __('lang.edit_arg', ['arg' => strtolower(__('lang.user'))]) }}</x-slot:content>
                                        <x-link data-tooltip-target="tooltip-edit-{{$user->id}}" href="{{ route('users.edit', $user) }}">
                                            <x-heroicon-o-pencil-square class="w-4 h-4 text-gray-300 dark:text-gray-200"/>
                                        </x-link>
                                    </x-tooltip>
                                    @endcan
                                    @can('users:delete')
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <x-tooltip id="tooltip-delete-{{$user->id}}">
                                                <x-slot:content>{{ __('lang.delete_arg', ['arg' => strtolower(__('lang.user'))]) }}</x-slot:content>
                                                <x-danger-button
                                                    data-tooltip-target="tooltip-delete-{{$user->id}}"
                                                    type="submit">
                                                    <x-heroicon-o-trash class="w-4 h-4 text-gray-300 dark:text-gray-200"/>
                                                </x-danger-button>
                                            </x-tooltip>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ __('lang.no_records_arg', ['arg' => strtolower(__('lang.user'))]) }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
