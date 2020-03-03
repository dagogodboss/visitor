<?php

namespace App\Http\Controllers;

use App\Events\AdminWizardSaved;
use App\Http\Controllers\Controller;
use App\Managers\SiteSettingsManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class SiteSettingsController extends Controller
{
    /**
     * @var SiteSettingsManager
     */
    protected $SiteSettingsManager;

    /**
     * @param SiteSettingsManager $environmentManager
     */
    public function __construct(SiteSettingsManager $environmentManager)
    {
        $this->SiteSettingsManager = $environmentManager;
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function siteSettings()
    {
        return view('vendor.installer.site-settings');
    }

    /**
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function saveSettings(Request $request, Redirector $redirect)
    {
        $rules     = [
            'site_name'    => 'required|string|max:255',
            'site_email'   => 'required|string|email|max:50',
            'site_phone'   => 'required|string|max:15',
            'site_address' => 'required|string|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('vendor.installer.site-settings', compact('errors'));
        }

        if ($request->has('site_logo')) {
            /* Image Upload */
            $imageName = time() . '.' . request()->site_logo->getClientOriginalExtension();
            request()->site_logo->move(public_path('images'), $imageName);
            /* end image upload */
            $requestData          = $request->except(['site_logo', '_token']);
            $requestData['site_logo'] = $imageName;
        } else {
            $requestData['site_logo'] = "no-image.png";
            $requestData          = $request->except('_token');
        }

        $results = $this->SiteSettingsManager->saveSiteSettings($requestData);

        return $redirect->route('LaravelInstaller::final')
            ->with(['results' => $results]);
    }
}
