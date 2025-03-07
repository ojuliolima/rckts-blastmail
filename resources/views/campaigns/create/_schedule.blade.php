<div class="flex flex-col gap-4">
    <div>
        <div>{{ __('From') }}:----@---.com</div>
        <div>{{ __('To') }}: #count de emails do email_list_id</div>
        <div>{{ __('Subject:') }} {{ $data['subject'] }}</div>
        <div>Template: #template</div>
    </div>
    <hr/>
    <div x-data="{ show: '{{ data_get($data, 'send_when', 'now') }}'}">
        <x-input-label :value="__('Schedule Delivery')" />
        <div class="flex flex-col gap-2 my-2">
            <x-input.radio x-model="show" value="now" id="send_now" name="send_when">{{ __('Send Now') }}</x-input.radio>
            <x-input.radio x-model="show" value="later" id="send_later" name="send_when">{{ __('Send Later') }}</x-input.radio>
        </div>
        <div x-show="show == 'later'">
            <x-input.text id="send_at" class="block mt-1 w-full" type="date" name="send_at" :value="old('send_at', $data['send_at'])" autofocus />
            <x-input-error :messages="$errors->get('send_at')" class="mt-2" />
        </div>
    </div>
</div>