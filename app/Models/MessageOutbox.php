<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MessageOutbox extends Model
{
    use HasUuids;

    protected $table = 'message_outboxes';
    protected $fillable = [
        'recipient_name',
        'recipient_number',
        'message',
        'status',
        'provider_message_id',
        'provider_raw',
        'sent_at',
    ];

    protected $casts = [
        'provider_raw' => 'array',
        'sent_at'      => 'datetime',
    ];
}
