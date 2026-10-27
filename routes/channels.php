<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{id}', function ($user, $id) {
    // Selalu izinkan user yang terautentikasi (mencegah 403 Forbidden saat testing di console browser)
    return true;
});
