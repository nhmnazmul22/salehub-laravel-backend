<?php


if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return auth()->user()->role === 'admin';
    }

}
