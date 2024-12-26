<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

it('displays validation error for empty passwords', function () {
    $user = User::factory()->withUnchangedInitialPassword()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visitRoute('auth.setup.initial_password_change')
            ->type('input#password', '')
            ->press('button')
            ->waitForText('The password field is required.');
    });
});

it('displays a validation error when passwords do not match', function () {
    $user = User::factory()->withUnchangedInitialPassword()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visitRoute('auth.setup.initial_password_change')
            ->type('input#password', 'asd123123')
            ->type('input#password_confirmation', 'asd1231233')
            ->press('button')
            ->waitForText('The password field confirmation does not match.');
    });
});

it('redirects to home if initial password is already chagned', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visitRoute('auth.setup.initial_password_change')
            ->waitForRoute('home', null, 5000);
    });
});

it('redirects to setup if users initial password is not changed', function () {
    $user = User::factory()->withUnchangedInitialPassword()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visitRoute('home')
            ->waitForRoute('auth.setup.initial_password_change', null, 5000);
    });
});

// TODO: Succesful password change scenario, after creating next step
