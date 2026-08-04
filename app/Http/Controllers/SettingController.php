<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(
            Setting::first()
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'usd_to_cdf' => 'required|numeric|min:1'
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'usd_to_cdf' => $request->usd_to_cdf
            ]);
        } else {
            $setting->update([
                'usd_to_cdf' => $request->usd_to_cdf
            ]);
        }

        return response()->json([
            'message' => 'Taux mis à jour',
            'data' => $setting
        ]);
    }
}
