<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GenerateInitialPassword
{
    /**
     * @return array<string,string>
     */
    public function __invoke(): array
    {
        $password = Str::password(10, true, true, false, false);
        $hashedPassword = Hash::make($password);

        return [$password, $hashedPassword];
    }
}
