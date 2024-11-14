<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDIENTE = 'pendiente';
    case PAGADA = 'pagada';
    case CANCELADA = 'cancelada';
    case EXPIRADA = 'expirada';
}
