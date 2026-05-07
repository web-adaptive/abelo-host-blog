<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Допустимые статусы публикации поста.
 */
enum StatusPostEnum: string
{
    case Published = 'published';
    case Banned = 'banned';
    case Template = 'template';
}
