@extends('layouts.home')

@section('content')
    <x-modal title="Upload Avatar">
        <div class="p-4">
            <div id="cropt_avatar"></div>
            <input name="avatar_url"
                autocomplete="off"
                class="hidden"
                id="crop_image_url" />
            <button id="crop"
                autocomplete="off"
                class="w-full rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Crop</button>
        </div>
    </x-modal>

    <div class="container mx-auto mt-4 flex items-start space-x-8">
        <div class="sticky top-4 w-1/3 space-y-4">
            <div class="w-full rounded-lg bg-white shadow">
                <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-100 p-3 text-sm font-semibold uppercase tracking-[0.03rem] text-gray-700">
                    Profile
                </h3>
                <a href="#account-settings"
                    class="block rounded-t-lg px-3 py-2 text-gray-800 hover:bg-gray-100">Account Settings</a>
                <a href="#work-history"
                    class="block rounded-b-lg px-3 py-2 text-gray-800 hover:bg-gray-100">Manage Work History</a>
            </div>

            <div class="w-full rounded-lg bg-white shadow">
                <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-100 p-3 text-sm font-semibold uppercase tracking-[0.03rem] text-gray-700">
                    Security
                </h3>
                <a href="#change-password"
                    class="block px-3 py-2 text-gray-800 hover:bg-gray-100">Change Password</a>
            </div>
        </div>
        <div class="w-full space-y-6">
            <div class="w-full rounded-md bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-semibold">Account Settings</h3>
                <div id="account-settings"
                    class="flex flex-col">
                    <h4 class="mb-4 text-base font-medium text-gray-700">Avatar</h4>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img class="h-[80px] w-[80px] rounded-full"
                                id="avatar"
                                src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
                                alt="Profile Avatar">
                            <div>
                                <h3 class="mb-1 text-base font-medium text-gray-900">Profile picture</h3>
                                <p class="text-sm text-gray-600">PNG, JPEG under 5MB</p>
                                <span id="avatar_url-validation-message"
                                    class="mt-2 block hidden text-sm text-red-500"></span>
                            </div>
                        </div>
                        <div id="controls"
                            class="flex justify-end space-x-2">
                            <button hx-patch="{{ route('auth.settings.avatar') }}"
                                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                                hx-include="[name='avatar_url']"
                                id="upload"
                                class="hidden rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Upload</button>
                            <button class="cursor-pointer rounded-md bg-blue-500 px-3 py-1 text-white"
                                id="uploadButton">
                                Upload New Avatar
                            </button>
                            <input type="file"
                                id="avatar_upload"
                                class="hidden"
                                :multiple="multiple"
                                :accept="accept" />
                            <button class="rounded-md bg-black px-3 py-1 text-white"
                                hx-patch="{{ route('auth.settings.avatarReset') }}"
                                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>Delete</button>
                        </div>
                    </div>
                </div>
                <div class="my-6 h-[1px] w-full bg-gray-200"></div>
                <div>
                    <h4 class="mb-4 text-base font-medium text-gray-700">Account Details</h4>
                    <form hx-put="{{ route('auth.settings.update') }}"
                        hx-swap="none">
                        @csrf
                        <x-form-input label="Name"
                            name="name"
                            :value="$user->name" />
                        <x-form-inline>
                            <x-form-select label="University Start Year"
                                name="uni_start_year"
                                between="2000,current"
                                :value="$user->uni_start_year" />
                            <x-form-select label="University Finish Year"
                                name="uni_finish_year"
                                between="2000,current"
                                :value="$user->uni_finish_year" />
                        </x-form-inline>
                        <x-form-textarea label="Biography"
                            name="bio"
                            :value="$user->bio"
                            limit="256" />
                        <button type="submit"
                            class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Change</button>
                    </form>
                </div>
            </div>

            <!-- TODO: Finish work history part -->
            <div id="work-history"
                class="w-full rounded-md bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-semibold">Manage Work History</h3>
                <div class="border border-gray-200 p-4">
                    @foreach ($user->workHistory as $wh)
                        <div class="bg-white shadow">
                            <li class="list-none">{{ $wh->position }}</li>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="change-password"
                class="w-full rounded-md bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-semibold">Change Password</h3>
                <form hx-patch="{{ route('auth.settings.changePassword') }}"
                    hx-swap="none">
                    @csrf
                    <x-form-input label="Password"
                        type="password"
                        name="password" />
                    <x-form-input label="Confirm Password"
                        type="password"
                        name="password_confirmation" />
                    <x-form-input label="Current Password"
                        type="password"
                        name="current_password" />
                    <button type="submit"
                        class="rounded-md bg-black px-3 py-1 text-white text-white">Change Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
