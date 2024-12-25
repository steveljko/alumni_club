<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

it('displays validation error for empty email', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('auth.password.forgot')
            ->type('input#email', '')
            ->press('button')
            ->waitForText('The email field is required.');
    });
});

it('displays validation error for short email', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('auth.password.forgot')
            ->type('input#email', 'a@a.a')
            ->press('button')
            ->waitForText('The email field must be at least 8 characters.');
    });
});

it('displays validation error for an invalid email', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('auth.password.forgot')
            ->type('input#email', 'test@example.com')
            ->press('button')
            ->waitForText('The selected email is invalid.');
    });
});

it('prevents deny sending multiple reset password emails for the same email in a short timeframe', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('auth.password.forgot')
            ->type('input#email', $user->email)
            ->press('button')
            ->waitForText('A reset link has been sent to your email.');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('auth.password.forgot')
                ->type('input#email', $user->email)
                ->press('button')
                ->waitForText('You can only request a password reset once every 10 minutes.', 5000);
        });
    });
});

it('allows multiple password reset email requests after time limit period', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('auth.password.forgot')
            ->type('input#email', $user->email)
            ->press('button')
            ->waitForText('A reset link has been sent to your email.');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('auth.password.forgot')
                ->plainCookie('dusk-skip-time', Carbon::now()->addMinutes(10))
                ->type('input#email', $user->email)
                ->press('button')
                ->waitForText('A reset link has been sent to your email.');
        });
    });
});

it('should display a toast notification and send a password reset email upon successful submission', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('auth.password.forgot')
            ->type('input#email', $user->email)
            ->press('button')
            ->waitForText('A reset link has been sent to your email.', 5000);
    });
});
