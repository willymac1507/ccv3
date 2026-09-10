<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('presence-users', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
