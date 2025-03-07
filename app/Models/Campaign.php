<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignFactory> */
    use HasFactory;
    use SoftDeletes;

    /*realiza o cast do campo dentro do model, tirando a necessidade de realizar o cast na hora do envio do email onde é realidado dessa forma Carbon::parse($campaign->send_at)*/
   /*  protected function casts()
    {
        return [
            'send_at' => 'datetime',
        ];
    } */

    public function emailList()
    {
        return $this->belongsTo(EmailList::class);
    }
}
