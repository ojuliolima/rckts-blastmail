<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Email List') }} > {{ $emailList->title }} > {{ __('Subscribers') }}
        </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div class="flex justify-between">
            <x-form :action="route('subscribers.index', $emailList)" class="w-2/5" x-data x-ref="form">
                <x-checkbox-input name="showTrash"
                    value="1"
                    @click="$refs.form.submit()" 
                    :checked="$showTrash"
                    :label="__('Show Deleted Records')"
                />
                <x-text-input name="search" :placeholder="__('Search')" :value="$search"/>
            </x-form>
        </div>
        <x-table :headers="['#', __('Name'), __('Email'), __('Actions') ]">
            <x-slot name="body">
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <x-table.td>{{ $subscriber->id }}</x-table.td>
                        <x-table.td>{{ $subscriber->name }}</x-table.td>
                        <x-table.td>{{ $subscriber->email }}</x-table.td>
                        <x-table.td>
                            @unless ($subscriber->trashed())
                            <x-form :action="route('subscribers.destroy', [$emailList, $subscriber])" method="delete" flat onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                <x-secondary-button type="submit">Delete</x-secondary-button>
                            </x-form>
                            @else
                                <span class="rounded-md w-fit border border-red-500 bg-red-500 px-2 py-1 text-xs font-medium text-white dark:border-red-500 dark:bg-red-500 dark:text-white">Deleted</span>
                            @endunless
                        </x-table.td>
                    </tr> 
                @endforeach   
            </x-slot>
        </x-table>
        {{ $subscribers->links() }}
    </x-card>
</x-layouts.app>
