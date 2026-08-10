<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = BusinessSetting::pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'business_name', 'business_address', 'business_phone',
            'business_email', 'receipt_footer', 'tax_rate',
            'tax_name', 'currency_symbol', 'currency_code', 'receipt_paper_size',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                BusinessSetting::set($field, $request->input($field));
            }
        }

        if ($request->hasFile('business_logo')) {
            $path = $request->file('business_logo')->store('logos', 'public');
            BusinessSetting::set('business_logo', $path);
        }

        return back()->with('success', 'Configuración actualizada exitosamente.');
    }
}
