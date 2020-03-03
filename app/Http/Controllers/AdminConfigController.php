<?php

namespace App\Http\Controllers;

use App\Events\AdminWizardSaved;
use App\Http\Controllers\Controller;
use App\Managers\AdminConfigManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class AdminConfigController extends Controller
{
    /**
     * @var AdminConfigManager
     */
    protected $AdminConfigManager;

    /**
     * @param AdminConfigManager $environmentManager
     */
    public function __construct(AdminConfigManager $environmentManager)
    {
        $this->AdminConfigManager = $environmentManager;
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function adminWizard()
    {
        return view('vendor.installer.admin-wizard');
    }

    /**
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function saveWizard(Request $request, Redirector $redirect)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('vendor.installer.admin-wizard', compact('errors'));
        }

        $results = $this->AdminConfigManager->saveAdminWizard($request);
        event(new AdminWizardSaved($request));

        return $redirect->route('LaravelInstaller::siteSettings')
                        ->with(['results' => $results]);
    }
}
