<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-4">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr>
        <th scope="col" class="px-6 py-3">
            {{ __('lang.room') }}
        </th>
        <th scope="col" class="px-6 py-3">
            {{ __('lang.description') }}
        </th>
        <th scope="col" class="flex px-6 py-3 justify-center items-center">
            <x-heroicon-o-bolt class="w-4 h-4 text-gray-500 dark:text-gray-200" />
        </th>
    </tr>
    </thead>
    <tbody id="roomsList">
    @if(isset($hotel))
        @forelse ($hotel->rooms as $room)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 room-data">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $room->name }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $room->description }}
                </td>
                <td class="px-6 py-4 w-44 items-center">
                    <x-button
                        title="{{ __('lang.edit_arg', ['arg' => strtolower(__('lang.room'))]) }}"
                        class="update-room"
                        data-edit-url="{{ route('rooms.edit', $room) }}"
                        data-update-url="{{ route('rooms.update', $room) }}"
                        type="button">
                        <x-heroicon-o-pencil-square class="w-4 h-4 text-gray-300 dark:text-gray-800"/>
                    </x-button>
                    <x-danger-button
                        title="{{ __('lang.delete_arg', ['arg' => strtolower(__('lang.room'))]) }}"
                        class="delete-room"
                        data-delete-url="{{ route('rooms.destroy', $room) }}"
                        type="button">
                        <x-heroicon-o-trash class="w-4 h-4 text-gray-300 dark:text-gray-200"/>
                    </x-danger-button>
                </td>
            </tr>
        @empty
            @if (!old('rooms'))
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" id="noRoom">
                    <td colspan="3"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{ __('lang.no_records_arg', ['arg' => strtolower(__('lang.room'))]) }}
                    </td>
                </tr>
            @endif
        @endforelse
    @elseif (!old('rooms'))
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" id="noRoom">
            <td colspan="3"
                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                {{ __('lang.no_records_arg', ['arg' => strtolower(__('lang.room'))]) }}
            </td>
        </tr>
    @endif
    @if (old('rooms'))
        @foreach(old('rooms') as $key => $room)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    <x-input class="block mt-1 w-full" type="text" name="rooms[{{$key}}][name]" :value="old('rooms[{{$key}}][name]')" required placeholder="{{ __('lang.name') }}" />
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    <x-input class="block mt-1 w-full" type="text" name="rooms[{{$key}}][description]" :value="old('rooms[{{$key}}][description]')" placeholder="{{ __('lang.description') }}" />
                </td>
                <td class="px-6 py-4 w-44 items-center">
                    <x-danger-button
                        type="button"
                    title="{{ __('lang.edit_arg', ['arg' => strtolower(__('lang.room'))]) }}"
                        onclick="window.deleteRoom(this);">
                        <x-heroicon-o-trash class="w-4 h-4 text-gray-300 dark:text-gray-200"/>
                    </x-danger-button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
