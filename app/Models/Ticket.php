<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'customer_id',
        'subject',
        'message',
        'status',
        'manager_reply_at', // renamed for clarity
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Optionally: define a media collection for files
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files')->singleFile();
    }
}
