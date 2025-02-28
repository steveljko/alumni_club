@extends('layouts.home')

@section('content')
    <div class="container mx-auto mt-4 block items-start space-x-0 md:flex md:space-x-8">
        <div class="static top-4 w-full space-y-4 md:sticky md:w-1/3">
            <div class="w-full rounded-lg bg-white shadow">
                <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-100 p-3 text-sm font-semibold uppercase tracking-[0.03rem] text-gray-700">
                    Profile
                </h3>
                <a href="#account-settings" class="block rounded-t-lg px-3 py-2 text-gray-800 hover:bg-gray-100">Account Settings</a>
                <a href="#work-history" class="block rounded-b-lg px-3 py-2 text-gray-800 hover:bg-gray-100">Manage Work History</a>
            </div>

            <div class="w-full rounded-lg bg-white shadow">
                <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-100 p-3 text-sm font-semibold uppercase tracking-[0.03rem] text-gray-700">
                    Security
                </h3>
                <a href="#change-password" class="block px-3 py-2 text-gray-800 hover:bg-gray-100">Change Password</a>
            </div>
        </div>
        <div class="mt-4 w-full space-y-6 md:mt-0">
            <div class="w-full rounded-md bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-semibold">Account Settings</h3>
                <div id="account-settings" class="flex flex-col">
                    <x-upload-avatar />
                </div>
                <div class="my-6 h-[1px] w-full bg-gray-200"></div>
                <div>
                    <h4 class="mb-4 text-base font-medium text-gray-700">Account Details</h4>
                    <form
                        hx-put="{{ route('users.settings.update') }}"
                        hx-indicator="#accountSettingsSpinner"
                        hx-swap="none"
                    >
                        <x-form-input
                            label="Name"
                            name="name"
                            :value="$user->name"
                        />
                        <x-form-input-group>
                            <x-form-select
                                label="University Start Year"
                                name="uni_start_year"
                                between="2000,current"
                                :value="$user->uni_start_year"
                            />
                            <x-form-select
                                label="University Finish Year"
                                name="uni_finish_year"
                                between="2000,current"
                                :value="$user->uni_finish_year"
                            />
                        </x-form-input-group>
                        <x-form-textarea
                            label="Biography"
                            name="bio"
                            :value="$user->bio"
                            limit="256"
                        />
                        <div class="flex justify-end">
                            <x-button
                                type="submit"
                                id="accountSettings"
                                spinner="true"
                            >Change</x-button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="work-history" class="w-full rounded-md bg-white p-6 shadow">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">
                        Manage Work History
                    </h3>
                    <div class="flex space-x-2">
                        @if (auth()->user()->hasUnpublishedWorkHistories())
                            <x-button
                                id="publishWorkHistories"
                                size="sm"
                                hx-put="{{ route('users.workHistories.publish') }}"
                            >Publish All</x-button>
                        @endif
                        <x-button
                            id="addPrevWork"
                            size="sm"
                            hx-get="{{ route('users.workHistories.create') }}"
                            hx-target="#dialog"
                            hx-swap="innerHTML"
                        >Add Previous Work</x-button>
                    </div>
                </div>
                <div
                    hx-get="{{ route('users.workHistories') }}"
                    hx-trigger="loadWorkHistories from:body"
                    hx-swap="innerHTML"
                >
                    @include('resources.user.workHistory.show', ['workHistory' => $user->workHistory])
                </div>
            </div>

            <div id="change-password" class="w-full rounded-md bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-semibold">Change Password</h3>
                <form
                    hx-patch="{{ route('users.settings.changePassword') }}"
                    hx-indicator="#changePasswordSpinner"
                    hx-swap="none"
                >
                    <x-form-input
                        label="Password"
                        type="password"
                        name="password"
                    />
                    <x-form-input
                        label="Confirm Password"
                        type="password"
                        name="password_confirmation"
                    />
                    <x-form-input
                        label="Current Password"
                        type="password"
                        name="current_password"
                    />
                    <div class="flex justify-end">
                        <x-button
                            type="submit"
                            id="changePassword"
                            spinner="true"
                            size="md"
                        >
                            Change Password
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
