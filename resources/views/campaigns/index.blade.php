<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Campaigns') }}
        </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div class="flex justify-between">
            <x-button.link :href="route('campaigns.create')">
                {{ __('Create a new campaign') }}
            </x-button.link>
            <x-form :action="route('campaigns.index')" x-data x-ref="form" class="w-3/5 flex space-x-4 items-center" flat>
                <x-input.checkbox name="withTrashed" value="1" @click="$refs.form.submit()" :checked="$withTrashed"
                    :label="__('Show Deleted Records')" />
                <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full" />
            </x-form>
        </div>
        <x-table :headers="['#', __('Name'), __('Actions')]">
            <x-slot name="body">
                @foreach ($campaigns as $campaign)
                    <tr>
                        <x-table.td class="w-1">{{ $campaign->id }}</x-table.td>
                        <x-table.td>
                            <a href="{{ route('campaigns.show', $campaign) }}">
                                {{ $campaign->name }}
                            </a>
                        </x-table.td>
                        <x-table.td class="w-1">
                            <div class="flex items-center space-x-4">   
                                @unless ($campaign->trashed())
                                <div>
                                    <x-form :action="route('campaigns.destroy', $campaign)" method="delete" flat
                                        onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        <x-button.secondary type="submit">{{ __('Delete') }}</x-button.secondary>
                                    </x-form>
                                </div>
                                @else
                                    <div>
                                        <x-form :action="route('campaigns.restore', $campaign)" method="patch" flat
                                            onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                            <x-button.secondary danger type="submit">{{ __('Restore') }}</x-button.secondary>
                                        </x-form>
                                    </div>
                                    <x-badge danger>{{ __('Deleted') }}</x-badge>
                                @endunless
                            </div>
                        </x-table.td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        {{ $campaigns->links() }}
    </x-card>
</x-layouts.app>
