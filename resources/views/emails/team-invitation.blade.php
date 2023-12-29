@component('mail::message')
{{ __('lang.mails.teams.invitation.block1', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('lang.mails.teams.invitation.block2') }}

@component('mail::button', ['url' => route('register')])
{{ __('lang.create_arg', ['arg' => strtolower(__('lang.account'))]) }}
@endcomponent

{{ __('lang.mails.teams.invitation.block3') }}

@else
{{ __('lang.mails.teams.invitation.block4') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('lang.accept_invitation') }}
@endcomponent

{{ __('lang.mails.teams.invitation.block5') }}
@endcomponent
