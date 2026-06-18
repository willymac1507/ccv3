<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client');
    }
}
