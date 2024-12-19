<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

it('logs in successfully with valid credentials', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visitRoute('login')
            ->type('input#email', $user->email)
            ->type('input#password', 'password')
            ->press('button')
            ->waitForRoute('home');
    });
});

it('displays validation errors for empty email and password fields', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('login')
            ->type('input#email', '')
            ->type('input#password', '')
            ->press('button')
            ->waitForText('The email field is required.')
            ->waitForText('The password field is required.');
    });
});

it('displays validation errors for short email and password', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('login')
            ->type('input#email', 'a@a.a')
            ->type('input#password', 'pass')
            ->press('button')
            ->waitForText('The email field must be at least 8 characters.')
            ->waitForText('The password field must be at least 8 characters.');
    });
});

it('displays validation error for invalid email format', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('login')
            ->type('input#email', 'a')
            ->press('button')
            ->waitForText('The email field must be a valid email address.');
    });
});

it('displays validation error for incorrect email or password', function () {
    $this->browse(function (Browser $browser) {
        $browser->visitRoute('login')
            ->type('input#email', 'test@example.com')
            ->type('input#password', 'password')
            ->press('button')
            ->waitForText('The provided credentials are incorrect.');
    });
});
