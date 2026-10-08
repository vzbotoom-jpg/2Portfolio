<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'budget',
        'timeline',
        'ip_address',
        'user_agent',
        'is_read',
        'read_at',
        'reply',
        'replied_at',
        'meta_data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'meta_data' => 'array',
    ];

    protected $attributes = [
        'is_read' => false,
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at?->format('d M Y, H:i');
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->message, 100);
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2);
    }
}