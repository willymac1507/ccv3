<?php

namespace App\Models;

use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Appointment extends Model
{
    /** @use HasFactory<AppointmentFactory> */
    use HasFactory;

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client');
    }

    public function organisation(): HasOneThrough
    {
        return $this->hasOneThrough(Organisation::class, User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
