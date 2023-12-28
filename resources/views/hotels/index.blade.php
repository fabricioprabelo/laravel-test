<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hotels list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @can('hotels:create')
                        <x-link href="{{ route('hotels.create') }}" class="m-4">Add new hotel</x-link>
                    @endcan
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Hotel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Rooms
                            </th>
                            <th scope="col" class="flex px-6 py-3 justify-center items-center">
                                <x-heroicon-o-bolt class="w-4 h-4 text-gray-500 dark:text-gray-200" />
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($hotels as $hotel)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $hotel->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap w-28">
                                    {{ $hotel->rooms()->count() }}
                                </td>
                                <td class="px-6 py-4 w-44 items-center">
                                    @can('hotels:update')
                                    <x-tooltip id="tooltip-edit-{{$hotel->id}}">
                                        <x-slot:content>Edit hotel</x-slot:content>
                                        <x-link data-tooltip-target="tooltip-edit-{{$hotel->id}}" href="{{ route('hotels.edit', $hotel) }}">
                                            <x-heroicon-o-pencil-square class="w-4 h-4 text-gray-300 dark:text-gray-200"/>
                                        </x-link>
                                    </x-tooltip>
                                    @endcan
                                    @can('hotels:delete')
                                        <form method="POST" action="{{ route('hotels.destroy', $hotel) }}" class="inline-block form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <x-tooltip id="tooltip-delete-{{$hotel->id}}">
                                                <x-slot:content>Delete hotel</x-slot:content>
                                                <x-danger-button
                                                    data-tooltip-target="tooltip-delete-{{$hotel->id}}"
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
                                    {{ __('No hotels found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $hotels->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
