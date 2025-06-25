@php
    $heading = __('filament::pages/auth/login.title');
@endphp

<x-filament-panels::page.simple>
    <x-slot name="header">
        <h2 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {{ $heading }}
        </h2>
    </x-slot>

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-white dark:bg-gray-900 px-2 text-gray-500 dark:text-gray-400">
                    {{ __('Or continue with') }}
                </span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            @foreach ($socialButtons as $button)
                <a href="#" class="inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-800 px-4 py-2 text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-offset-0">
                    <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="{{ $button['icon'] }}"/>
                    </svg>
                    <span class="ml-2">{{ $button['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</x-filament-panels::page.simple> 