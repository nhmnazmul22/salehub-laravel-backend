<?php

namespace App\Enums;

enum VatType: string
{
    case PERCENT = 'percent';
    case FIXED = 'fixed';
}
