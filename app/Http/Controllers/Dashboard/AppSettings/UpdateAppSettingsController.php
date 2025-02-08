<?php

namespace App\Http\Controllers\Dashboard\AppSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAppSettingsRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class UpdateAppSettingsController extends Controller
{
    public function __invoke(UpdateAppSettingsRequest $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->all() as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
            }
        });

        Cache::forget('settings');

        return $this->toast('Settings updated!');
    }
}
