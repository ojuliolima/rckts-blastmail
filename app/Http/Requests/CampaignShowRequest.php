<?php

namespace App\Http\Requests;

use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;

class CampaignShowRequest extends FormRequest
{
    public function checkWhat(): RedirectResponse | false 
    {
        if(is_null($this->route('what'))) {
            return to_route('campaigns.show', ['campaign' => $this->route('campaign'), 'what' => 'statistics']);
        }

        return false;
    }

    public function authorize(): bool
    {
        $what = $this->route('what') ?: 'statistics';
        abort_unless(in_array($what, ['statistics', 'open', 'clicked']), 404, 'Rota não encontrada');

        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
