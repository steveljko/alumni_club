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

    <div class="container mx-auto mt-4 space-y-4">
        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Account Settings</h3>
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

        <div class="w-full rounded-md p-4 shadow">
            <h3 class="mb-4 text-lg font-semibold">Change Avatar</h3>
            <div class="flex-start flex flex-col">
                <div class="flex space-x-[32px]">
                    <img class="h-[128px] w-[128px] rounded-full"
                        id="avatar"
                        src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
                        alt="Profile Avatar">
                    <div id="controls">
                        <button hx-patch="{{ route('auth.settings.avatar') }}"
                            hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                            hx-include="[name='avatar_url']"
                            id="upload"
                            class="hidden rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Upload</button>
                        <span id="avatar_url-validation-message"
                            class="mt-2 block hidden text-sm text-red-500"></span>
                        <label class="mt-6 cursor-pointer"
                            tabindex="-1">
                            <span class="rounded-md bg-blue-500 px-3 py-1 text-white">Select Avatar</span>
                            <input type="file"
                                id="avatar_upload"
                                class="hidden"
                                :multiple="multiple"
                                :accept="accept" />
                        </label>
                        <button class="rounded-md bg-black px-3 py-1 text-white text-white"
                            hx-patch="{{ route('auth.settings.avatarReset') }}"
                            hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Change Password</h3>
        </div>

        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Manage Work History</h3>
        </div>
    </div>
@endsection
