<?php

namespace App\Enums\Auth;

enum AccountSetupProgress: string
{
    case STEP1 = 'step.1';

    case STEP2 = 'step.2';

    case STEP3 = 'step.3';

    case COMPLETED = 'completed';
}
