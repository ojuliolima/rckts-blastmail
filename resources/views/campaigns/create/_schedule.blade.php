<div class="flex flex-col gap-4">
    <div>
        <div>{{ __('From') }}:----@---.com</div>
        <div>{{ __('To') }}: #count de emails do email_list_id</div>
        <div>{{ __('Subject:') }} {{ $data['subject'] }}</div>
        <div>Template: #template</div>
    </div>
    <hr/>
        <div class="flex flex-col gap-2">
            <x-input-label :value="__('Schedule Delivery')" class="mt-2" />
            <x-input.radio id="send_now" name="send_when">{{ __('Send Now') }}</x-input.radio>
            <x-input.radio id="send_later" name="send_when">{{ __('Send Later') }}</x-input.radio>
        </div>
    </div>

    <div>
        <x-input-label for="send_at" :value="__('Send at')" />
        <x-input.text id="send_at" class="block mt-1 w-full" type="date" name="send_at" :value="old('send_at', $data['send_at'])" autofocus />
        <x-input-error :messages="$errors->get('send_at')" class="mt-2" />
    </div>
</div>