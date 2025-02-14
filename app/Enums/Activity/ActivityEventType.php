<?php

namespace App\Enums\Activity;

enum ActivityEventType: string
{
    case CREATE = 'create';

    case UPDATE = 'update';

    case DELETE = 'delete';

    case LOGIN = 'login';

    case LOGOUT = 'logout';
}
