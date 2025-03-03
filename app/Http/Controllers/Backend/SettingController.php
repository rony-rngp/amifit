<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function settings(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
               'website_name' => 'required',
               'whatsapp_number' => 'required',
               'banner_title' => 'required',
               'banner_subtitle' => 'required',
               'footer_title' => 'required',
               'facebook_url' => 'required',
               'instagram_url' => 'required',
               'twitter_url' => 'required',
               'copyright_text' => 'required',
            ]);

            Setting::updateOrInsert(['key' => 'website_name'], [
                'value' => $request['website_name']
            ]);
            Setting::updateOrInsert(['key' => 'whatsapp_number'], [
                'value' => $request['whatsapp_number']
            ]);
            Setting::updateOrInsert(['key' => 'banner_title'], [
                'value' => $request['banner_title']
            ]);
            Setting::updateOrInsert(['key' => 'banner_subtitle'], [
                'value' => $request['banner_subtitle']
            ]);
            Setting::updateOrInsert(['key' => 'footer_title'], [
                'value' => $request['footer_title']
            ]);
            Setting::updateOrInsert(['key' => 'facebook_url'], [
                'value' => $request['facebook_url']
            ]);
            Setting::updateOrInsert(['key' => 'instagram_url'], [
                'value' => $request['instagram_url']
            ]);
            Setting::updateOrInsert(['key' => 'twitter_url'], [
                'value' => $request['twitter_url']
            ]);
            Setting::updateOrInsert(['key' => 'copyright_text'], [
                'value' => $request['copyright_text']
            ]);
            Setting::updateOrInsert(['key' => 'meta_title'], [
                'value' => $request['meta_title']
            ]);
            Setting::updateOrInsert(['key' => 'meta_keywords'], [
                'value' => $request['meta_keywords']
            ]);
            Setting::updateOrInsert(['key' => 'meta_description'], [
                'value' => $request['meta_description']
            ]);

            if($request->file('favicon')){
                Setting::updateOrInsert(['key' => 'favicon'], [
                    'value' => update_image('settings/', get_settings('favicon'), $request['favicon'])
                ]);
            }


            return redirect()->back()->with('success', 'Setting Updated Successfully');

        }
        return view('backend.settings');
    }
}
