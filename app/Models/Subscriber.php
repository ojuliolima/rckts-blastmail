<?php

namespace App\Models;

use App\Models\EmailList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriberFactory> */
    use HasFactory;
    use SoftDeletes;

    public function emailList() : BelongsTo
    {
        return $this->belongsTo(EmailList::class);
    }
}
