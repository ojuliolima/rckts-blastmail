<div class="gap-4 flex-col flex">
    <x-alert success no-icon :title="__('Your campaign has been sent to '. $query['total_subscribers'] .' subscribers from list '. $campaign->EmailList->title)"/>
   <div class="grid grid-cols-3 gap-5">
        <x-dashboard.card :heading="$query['total_openings']" subheading="{{ __('Opens') }}"/>
        <x-dashboard.card :heading="$query['unique_openings']" subheading="{{ __('Unique Opens') }}"/>
        <x-dashboard.card heading="{{ $query['openings_rate'] }}%" subheading="{{ __('Open rate') }}"/>
        <x-dashboard.card :heading="$query['total_clicks']" subheading="{{ __('Clicks') }}"/>
        <x-dashboard.card :heading="$query['unique_clicks']" subheading="{{ __('Unique Clicks') }}"/>
        <x-dashboard.card heading="{{ $query['clicks_rate'] }}%" subheading="{{ __('Clicks Rate') }}"/>
    </div> 
</div>