<div class="gap-4 flex-col flex">
    <x-alert success no-icon title='Your campaign is ready to be send!'/>
    <div class="grid grid-cols-3 gap-5">
        <x-dashboard.card heading="01" subheading="{{ __('Opens') }}"/>
        <x-dashboard.card heading="02" subheading="{{ __('Unique Opens') }}"/>
        <x-dashboard.card heading="20%" subheading="{{ __('Open rate') }}"/>
        <x-dashboard.card heading="0" subheading="{{ __('Clicks') }}"/>
        <x-dashboard.card heading="0" subheading="{{ __('Unique Clicks') }}"/>
        <x-dashboard.card heading="20%" subheading="{{ __('Clicks Rate') }}"/>
    </div>
</div>