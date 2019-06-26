<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    public function termAndCondition()
    {
        return view('admin.setting.term_and_condition')
            ->with([
                'data' => Setting::where('key', 'term_and_condition')->first()
            ]);
    }

    public function termAndConditionUpdate(Request $request)
    {
        $data = Setting::where('key', 'term_and_condition')->first();
        $data->value = $request->term_and_condition;
        $data->save();

        return redirect()->route('admin.term_and_condition')
            ->with('status', 'Term And Condition updated');
    }
}
