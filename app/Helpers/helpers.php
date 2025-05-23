<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null) {
        return Setting::where('key', $key)->value('value') ?? $default;
    }
}

if (!function_exists('formatMoney')) {
    function formatMoney($amount, $currency = '$') {
        return $currency . number_format($amount, 2);
    }
}