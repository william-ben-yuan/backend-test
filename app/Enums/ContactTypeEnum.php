<?php

namespace App\Enums;

enum ContactTypeEnum: string
{
    case Phone = 'telefone';
    case Email = 'email';
    case Whatsapp = 'whatsapp';
}
