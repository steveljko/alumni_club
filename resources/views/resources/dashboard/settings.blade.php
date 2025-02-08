@extends('layouts.dashboard')

@section('content')
    <div class="w-full rounded-lg bg-white p-4 shadow" id="wrapper">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold">App Settings</h3>
        </div>
        <div>
            <form hx-put="{{ route('admin.settings') }}" hx-indicator="#saveSpinner">
                <x-form-input
                    label="Site name"
                    name="site_name"
                    value="{{ config('settings.site_name') }}"
                />

                <x-form-toggle
                    label="Maintenance Mode"
                    name="maintenance_mode"
                    placeholder="Enable app maintenance mode"
                    value="{{ config('settings.maintenance_mode') }}"
                />

                <x-button
                    spinner="true"
                    type="submit"
                    id="save"
                >Save</x-button>
            </form>
        </div>
    </div>
@endsection
