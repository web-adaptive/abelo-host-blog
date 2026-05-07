<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusPostEnum: string
{
    case Published = 'published';
    case Banned = 'banned';
    case Template = 'template';
}
