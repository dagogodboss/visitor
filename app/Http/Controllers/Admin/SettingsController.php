<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Managers\SiteSettingsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Setting;

class SettingsController extends Controller
{
    /**
     * @var SiteSettingsManager
     */
    protected $SiteSettingsManager;

    /**
     * @param SiteSettingsManager $siteSettingsManager
     * @internal param SiteSettingsManager $environmentManager
     */
    public function __construct(SiteSettingsManager $siteSettingsManager)
    {
        $this->SiteSettingsManager = $siteSettingsManager;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.create', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null $type
     * @return \Illuminate\View\View
     */
    public function create($type = null)
    {
        return view('admin.settings.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param null $type
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($type = null, Request $request)
    {

        $errors = [];
        if($type=="notifications") {
            $validator = Validator::make($request->all(), $this->notificationsSettingsRules());
            if ($validator->fails())
                $errors = $validator->errors();
        } elseif ($type=="front-end") {
            $validator = Validator::make($request->all(), $this->frontEndSettingsRules());
            if ($validator->fails())
                $errors = $validator->errors();
        }elseif ($type=="front-end-ed") {
            $validator = Validator::make($request->all(), $this->frontEndSettingsEDRules());
            if ($validator->fails())
                $errors = $validator->errors();
        } elseif ($type=="photo_id_card") {
            $validator = Validator::make($request->all(), $this->photoIdCardSettingsRules());
            if ($validator->fails())
                $errors = $validator->errors();
        } else {
            $validator = Validator::make($request->all(), $this->generalSettingsRules());
            if ($validator->fails())
                $errors = $validator->errors();
        }

        if(count($errors)) {
            return view('admin.settings.create', compact('errors','type'));
        }
        $this->SiteSettingsManager->updateSettings($request);
        return redirect("admin/settings/$type")->with('flash_message', 'Setting added!');
    }

    /*
     * General Setting validation rules
     */
    public function generalSettingsRules()
    {
        return [
            'site_name'     => 'required|max:55',
            'site_email'    => 'required|email|max:40',
            'site_phone'    => 'required',
            'site_address'  => 'required',
        ];
    }

    /*
     * Notifications Setting validation rules
     */
    public function notificationsSettingsRules()
    {
        return [
            'notifications_email'   => 'required',
            'notifications_sms'     => 'required',
            'sms_gateway'           => 'required',
        ];
    }

    /*
     * Notifications Setting validation rules
     */
    public function frontEndSettingsRules()
    {
        return [
            'visitor_agreement'   => 'required'
        ];
    }
    public function frontEndSettingsEDRules()
    {
        return [
            'front_end_enable_disable'   => 'required'
        ];
    }

    /*
     * ID card Setting validation rules
     */
    public function photoIdCardSettingsRules()
    {
        return [
            // 'visitor_img_capture'   => 'required',
            // 'employ_img_capture'     => 'required',
            // 'id_card_template'     => 'required',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return view('admin.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'key' => 'required|string|unique:settings,key,' . $id,
                'value' => 'required'
            ]
        );
        $requestData = $request->all();

        $setting = Setting::findOrFail($id);
        $setting->update($requestData);

        return redirect('admin/settings')->with('flash_message', 'Setting updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Setting::destroy($id);

        return redirect('admin/settings')->with('flash_message', 'Setting deleted!');
    }
}
