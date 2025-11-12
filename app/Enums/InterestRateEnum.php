<?php

namespace App\Enums;

enum InterestRateEnum: string
{
    case NONE = '0';
    case TWO = '2.00';
    case FIVE = '5.00';
    case EIGHT = '8.00';
    case TEN = '10.00';
    case TWELVE = '12.00';
    case FIFTEEN = '15.00';
    case OTHER = 'other';
}
