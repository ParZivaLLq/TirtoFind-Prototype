<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('pages.admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'auto_scan_enabled' => ['nullable', 'boolean'],
            'similarity_threshold' => ['required', 'integer', 'min:0', 'max:100'],
            'retention_days' => ['required', 'integer', 'min:1', 'max:3650'],
        ]);

        $data['auto_scan_enabled'] = $request->boolean('auto_scan_enabled') ? '1' : '0';
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Pengaturan',
            'details' => 'Mengubah konfigurasi AI dan retensi data sistem.',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
