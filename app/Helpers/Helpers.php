<?php


function isAdmin(): bool
{
    return auth()->user()->role === 'admin';
}
