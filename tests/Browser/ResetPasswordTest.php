<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

it('displays validation error for empty passwords', function () {
    Mail::fake();
    $user = User::factory()->create();
    $user->sendPasswordRecoveryMail();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('auth.password.reset', ['token' => $user->password_reset_token])
            ->type('input#password', '')
            ->press('button')
            ->waitForText('The password field is required.');
    });
});

it('displays a validation error when passwords do not match', function () {
    Mail::fake();
    $user = User::factory()->create();
    $user->sendPasswordRecoveryMail();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('auth.password.reset', ['token' => $user->password_reset_token])
            ->type('input#password', 'asd123123')
            ->type('input#password_confirmation', 'asd1231233')
            ->press('button')
            ->waitForText('The password field confirmation does not match.');
    });
});

it('should display a toast notification on homepage after password change success', function () {
    Mail::fake();
    $user = User::factory()->create();
    $user->sendPasswordRecoveryMail();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('auth.password.reset', ['token' => $user->password_reset_token])
            ->type('input#password', 'asd123123')
            ->type('input#password_confirmation', 'asd123123')
            ->press('button')
            ->waitForRoute('home')
            ->waitForText('Successfully reseted password!');
    });
});

it('should display a toast notification when invalid token is provided', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('auth.password.reset', ['token' => 'asd'])
            ->waitForRoute('auth.login')
            ->waitForText('Invalid token is provided!');
    });
});
