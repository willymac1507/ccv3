<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'service_user');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
