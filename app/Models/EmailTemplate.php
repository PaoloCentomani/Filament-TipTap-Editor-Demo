<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'body',
        'name',
        'signature',
        'subject',
        'attach_documents',
        'attach_receipt',
        'sender_name',
        'sender_email',
        'recipient_email',
        'cc_recipients',
        'notes',
    ];

    protected $casts = [
        'sender_email' => 'json',
        'recipient_email' => 'json',
        'cc_recipients' => 'json',
        'subject' => 'json',
        'body' => 'json',
        'signature' => 'json',
    ];

    /**
     * The Tasks that belong to the EmailTemplate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
