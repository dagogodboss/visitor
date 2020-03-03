<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PreRegister;
use App\Setting;
use App\Models\Employee;
use App\User;
use Mail;
use DB;
use Excel;

class pre_registerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $pre_register = PreRegister::where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->orWhere('company_name', 'LIKE', "%$keyword%")
                ->orWhere('expected_date', 'LIKE', "%$keyword%")
                ->orWhere('expected_time', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $pre_register = PreRegister::latest()->paginate($perPage);
        }

        return view('admin.pre_register.index', compact('pre_register'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $employees    = User::latest()->whereHas('roles', function ($q) {
            $q->whereIn('name', ['employee']);
        })->pluck('name', 'id')->all();

        return view('admin.pre_register.create', compact('employees'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $userID = auth()->user()->id;
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'company_name'  => '',
            'email'         => 'required',
            'phone'         => 'required',
            'expected_date' => 'required',
            'expected_time' => 'required',
            'host_id'       => 'required|numeric',
        ]);

        $visitor = DB::table('pre_registers')->orderBy('visitorID', 'desc')->first();
        $date    = date('y-m-d');
        $data    = substr($date, 0, 2);
        $data1   = substr($date, 3, 2);
        $data2   = substr($date, 6, 8);

        if ($visitor) {
            $value = substr($visitor->visitorID, -2);
            if ($value < 1000) {
                $visitorID = $data2 . $data1 . $data . $value + 1;
            } else {
                $visitorID = $data2 . $data1 . $data . '01';
            }
        } else {
            $visitorID = $data2 . $data1 . $data . '01';
        }

        $id   = $request['host_id'];
        $host = $employee = User::find($id);

        $pre_register                = new PreRegister();
        $pre_register->first_name    = $request['first_name'];
        $pre_register->last_name     = $request['last_name'];
        $pre_register->email         = $request['email'];
        $pre_register->company_name  = $request['company_name'];
        $pre_register->phone         = $request['phone'];
        $pre_register->host_name     = $host->name;
        $pre_register->host_id       = $host->id;
        $pre_register->visitorID     = $visitorID;
        $pre_register->date          = date('d-m-Y');
        $pre_register->expected_date = $request['expected_date'];
        $pre_register->expected_time = $request['expected_time'];
        $pre_register->comment       = $request['comment'];
        $pre_register->user_id       = $userID;

        $pre_register->save();

        if ($request['invite_visitor'] == 'on') {
            $email = $request['email'];
            $data  = array(
                'first_name'    => $request['first_name'],
                'last_name'     => $request['last_name'],
                'name'          => $request['first_name'].' '.$request['last_name'],
                'email'         => $request['email'],
                'company_name'  => $request['company_name'],
                'phone'         => $request['phone'],
                'host'          => $host->name,
                'visitorID'     => $visitorID,
                'expected_date' => $request['expected_date'],
                'expected_time' => $request['expected_time'],
                'comment'       => $request['comment'],
                'invite'        => setting('invite_templates'),
            );

            Mail::send('admin.invite', $data, function ($message) use ($email) {
                $message->to($email, 'Visitor New')->subject('Visitors Invite');
                $message->from(setting('site_email'), setting('site_name'));
            });
            return redirect('admin/pre_register')->with('flash_message', 'pre register added and mail send!');
        } else {
            return redirect('admin/pre_register')->with('flash_message', 'pre register added!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pre_register = PreRegister::findOrFail($id);

        return view('admin.pre_register.show', compact('pre_register'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $pre_register = PreRegister::findOrFail($id);
        $employees    = User::latest()->whereHas('roles', function ($q) {
            $q->whereIn('name', ['employee']);
        })->pluck('name', 'id')->all();

        return view('admin.pre_register.edit', compact('pre_register', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'first_name'    => 'required|min:2|max:255',
            'last_name'     => 'required|min:2|max:255',
            'email'         => 'required|min:2|max:50|email',
            'phone'         => 'required||min:6|max:15',
            'expected_date' => 'required',
            'expected_time' => 'required',
            'host_id'       => 'required|numeric',
        ]);

        $host_id = $request['host_id'];
        $host    = $employee = User::find($host_id);
        $pre_register = PreRegister::findOrFail($id);

        $pre_register->first_name    = $request['first_name'];
        $pre_register->last_name     = $request->get('last_name');
        $pre_register->email         = $request['email'];
        $pre_register->company_name  = $request['company_name'];
        $pre_register->phone         = $request['phone'];
        $pre_register->host_name     = $host->name;
        $pre_register->host_id       = $host->id;
        $pre_register->date          = date('d-m-Y');
        $pre_register->expected_date = $request['expected_date'];
        $pre_register->expected_time = $request['expected_time'];
        $pre_register->comment       = $request['comment'];

//        dd($pre_register);
        $pre_register->save();
        if ($request['invite_visitor'] == 'on') {
            $settings = Setting::all();

            $email = $request['email'];
            $data  = array(
                'name'          => $request['first_name'].' '.$request['last_name'],
                'email'         => $request['email'],
                'company_name'  => $request['company_name'],
                'phone'         => $request['phone'],
                'host'          => $host->name,
                'visitorID'     => $pre_register->visitorID,
                'expected_date' => $request['expected_date'],
                'expected_time' => $request['expected_time'],
                'comment'       => $request['comment'],
                'invite'        => $settings[0]->invite_templates,
            );

            Mail::send('admin.invite', $data, function ($message) use ($email) {
                $message->to($email, 'Visitor New')->subject('Pre Registered Visitor Acknowledgement!');
                $message->from(setting('site_email'), setting('site_title'));
            });
        }


        return redirect('admin/pre_register')->with('flash_message', 'Pre register data updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        PreRegister::destroy($id);

        return redirect('admin/pre_register')->with('flash_message', 'pre-register deleted!');
    }

    public function datevalue(Request $request)
    {

        $date    = $request['date'];
        $perPage = 25;
        if ($request['date']) {
            $pre_register = PreRegister::whereBetween('date', [$date, $date])->latest()->paginate($perPage);
        } else {
            $pre_register = PreRegister::latest()->paginate($perPage);
        }

        return view('admin.pre_register.index', compact('pre_register'));
    }


    public function export(Request $request)
    {

        $date      = $request['date'];
        $date      = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate   = date('d-m-Y', strtotime($date[1]));

        $data = array();

        if ($request['date']) {
            $items = PreRegister::whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $items = PreRegister::all();
        }

        foreach ($items as $key => $value) {
            $data[$key]['ID']            = $key + 1;
            $data[$key]['Name']          = $value->first_name;
            $data[$key]['Email']         = $value->email;
            $data[$key]['Phone']         = $value->phone;
            $data[$key]['VisitorID']     = $value->visitorID;
            $data[$key]['Date']          = $value->date;
            $data[$key]['Host']          = $value->host_name;
            $data[$key]['Expected Date'] = $value->expected_date;
            $data[$key]['Expected Time'] = $value->expected_time;
        }

        Excel::create('pre-register', function ($excel) use ($data) {
            $excel->sheet('ExportFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

        return redirect('admin/pre_register');

    }


    public function sendEmail(Request $request)
    {


        $date      = $request['date'];
        $date      = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate   = date('d-m-Y', strtotime($date[1]));

        $data = array();

        if ($request['date']) {
            $items = PreRegister::whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $items = PreRegister::all();
        }

        foreach ($items as $key => $value) {
            $data[$key]['ID']            = $key + 1;
            $data[$key]['Name']          = $value->first_name;
            $data[$key]['Email']         = $value->email;
            $data[$key]['Phone']         = $value->phone;
            $data[$key]['VisitorID']     = $value->visitorID;
            $data[$key]['Date']          = $value->date;
            $data[$key]['Host']          = $value->host_name;
            $data[$key]['Expected Date'] = $value->expected_date;
            $data[$key]['Expected Time'] = $value->expected_time;
        }

        $file = Excel::create('pre_register', function ($excel) use ($data) {
            $excel->sheet('ExportFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->save('xls', storage_path('excel/exports'), true);

        $dataemail = array(
            'to'      => $request['to'],
            'subject' => $request['subject'],
            'file'    => $file['full'],
            'body'    => $request['body'],
        );


        Mail::send('admin.pre_register.email', $dataemail, function ($message) use ($dataemail) {
            $message->to($dataemail['to'])->subject($dataemail['subject']);
            $message->attach($dataemail['file']);
            $message->from(setting('site_email'), setting('site_name'));
        });

        return redirect('admin/pre_register');
    }

}
