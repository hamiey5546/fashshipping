<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'mapboxToken' => Setting::getValue('mapbox_token'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mapbox_token' => ['nullable', 'string', 'max:500'],
        ]);

        $value = $data['mapbox_token'] ?? null;
        $value = is_string($value) ? trim($value) : null;
        $value = $value === '' ? null : $value;

        Setting::putValue('mapbox_token', $value);

        return redirect()->route('admin.settings.edit')->with('status', 'Settings saved.');
    }
}
