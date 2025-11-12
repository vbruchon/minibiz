<?php

namespace App\Enums;

enum PaymentTermsEnum: string
{
    case UPON_RECEIPT = 'À réception';
    case NET_15 = '15 jours nets';
    case NET_30 = '30 jours nets';
    case END_OF_MONTH_30 = '30 jours fin de mois';
    case END_OF_MONTH_45 = '45 jours fin de mois';
    case OTHER = 'other';
}
