<?php

namespace App\Http\Requests;

use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;

class CampaignShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool | RedirectResponse
    {
        $campaign = $this->route('campaign');
        $what = $this->route('what');

        if(is_null($what)) {
            return to_route('campaigns.show', ['campaign' => $campaign, 'what' => 'statistics']);
        }
        
        abort_unless(in_array($what, ['statistics', 'open', 'clicked']), 404, 'Rota não encontrada');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
