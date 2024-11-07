<?php
declare(strict_types=1);

namespace ProjectUtilities;

enum UserRole: string
{
    case Admin = 'admin';
    case Gamer = 'gamer';
}
