<?php

namespace App\Enums;

enum RoleType: string
{
    case ADMIN = 'admin';
    case BRANCH_MANAGER = 'branch_manager';
    case STAFF = 'staff';
}
