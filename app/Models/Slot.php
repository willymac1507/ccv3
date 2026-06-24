<?php

namespace App\Models;

use Database\Factories\SlotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Slot extends Model
{
    /** @use HasFactory<SlotFactory> */
    use HasFactory;

    public function student(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
