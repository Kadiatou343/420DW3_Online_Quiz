<?php
declare(strict_types=1);

namespace ProjectUtilities;

enum UserRole: string
{
    case ADMIN = 'admin';
    case GAMER = 'gamer';
}
