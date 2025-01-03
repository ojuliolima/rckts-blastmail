<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Email List') }}
        </h2>
    </x-slot>

    <x-card>
        @forelse ($emailLists as $list)
                    
        @empty
        <div class="flex justify-center">
            <x-link-button :href="route('email-list.create')">
                {{ __('Create your first email list') }}
            </x-link-button>
        </div>
        @endforelse
    </x-card>
</x-layouts.app>
