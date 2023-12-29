<x-action-section>
    <x-slot name="title">
        {{ __('lang.pages.teams.team_settings.delete_title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('lang.pages.teams.team_settings.delete_description') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('lang.pages.teams.team_settings.delete_description2') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('lang.pages.teams.team_settings.delete_title') }}
            </x-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('lang.pages.teams.team_settings.delete_title') }}
            </x-slot>

            <x-slot name="content">
                {{ __('lang.pages.teams.team_settings.delete_confirmation') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('lang.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ __('lang.pages.teams.team_settings.delete_title') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>
