<?php

namespace App\Http\Controllers\Admin;

use App\Events\VisitorCheckedIn;
use App\Http\Controllers\Controller;
use App\Mail\VisitorListExcel;
use App\User;
use App\Setting;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Events\SendSmsVisitorHost;

use DB;
use Mail;
use Excel;

class visitorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $visitors = Visitor::where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $visitors = Visitor::latest()->paginate($perPage);
        }
        return view('admin.visitors.index', compact('visitors'));
    }

    public function create()
    {
        $employees = User::latest()->whereHas('roles', function($q) {
            $q->whereIn('name', ['employee'] );
        })->get();

       return view('admin.visitors.create',compact('employees'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name'    => 'required|max:50',
                'last_name'     => 'required|max:50',
                'phone'         => 'max:15|required',
                'email'         => 'required|string|max:55|email',
                'host_id'       => 'required|numeric',
            ]
        );
        $visitor = DB::table('visitors')->orderBy('visitorID', 'desc')->first();
        $date = date('y-m-d');
        $data = substr($date, 0, 2);
        $data1 = substr($date, 3, 2);
        $data2 = substr($date, 6, 8);

        if ($visitor) {
            $value = substr($visitor->visitorID, -2);
            if ($value < 100) {
                $visitorID = $data . $data1 . $data2 . $value + 1;
            } else {
                $visitorID = $data . $data1 . $data2 . '00';
            }
        } else {
            $visitorID = $data . $data1 . $data2 . '00';
        }

        if (!empty($request['photo'])) {
            $encoded_data = $request['photo'];
            $image = str_replace('data:image/png;base64,', '', $encoded_data);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10) . '.' . 'png';
            Storage::disk('public')->put('img/' . $imageName, base64_decode($image));
        } else {
            $imageName = null;
        }

        $id = $request['host_id'];
        $host =  $employee = User::find($id);
        $visitors = new visitor();
        $visitors->first_name = $request['first_name'];
        $visitors->last_name = $request['last_name'];
        $visitors->email = $request['email'];
        $visitors->company_name = $request['company_name'];
        $visitors->phone = $request['phone'];
        $visitors->visitorID = $visitorID;
        $visitors->photo = $imageName;
        $visitors->date = date('d-m-Y');

        $visitors->host_name = $host->name;
        $visitors->host_id = $host->id;

        $visitors->save();
        if ($visitors) {
            return redirect(route('admin.visitors'))->with('success', trans('Create Successfully'));
        }

    }

    public function show($id)
    {
        $visitor = Visitor::find($id);
        $settings = Setting::all();
        if($settings != ''){
            return view('admin.visitors.show', compact('visitor', 'settings'));
        } else {
            $settings = null;
            return view('admin.visitors.show', compact('visitor', 'settings'));
        }

    }

    public function edit($id)
    {
        $employees = User::latest()->whereHas('roles', function($q) {
            $q->whereIn('name', ['employee'] );
        })->get();
            $visitor = Visitor::find($id);
            return view('admin.visitors.edit', compact('visitor', 'employees'));
    }

    public function update(Request $request, $id)
    {
        if (!empty($request['photo'])) {
            $encoded_data = $request['photo'];
            $image = str_replace('data:image/png;base64,', '', $encoded_data);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10) . '.' . 'png';
            Storage::disk('public')->put('img/' . $imageName, base64_decode($image));
        } else {
            $imageName = null;
        }

        $hostID = $request['host_id'];
        $host =  $employee = User::find($hostID);

        $visitor = Visitor::find($id);
        $visitor->first_name = $request['first_name'];
        $visitor->last_name = $request['last_name'];
        $visitor->email = $request['email'];
        $visitor->company_name = $request['company_name'];
        $visitor->phone = $request['phone'];
        $visitor->photo = $imageName;
        $visitor->date = date('d-m-Y');
        $visitor->host_name = $host->name;
        $visitor->host_id = $host->id;
        $visitor->save();

        if ($visitor) {
            return redirect(route('admin.visitors'))->with('success', trans('Update Successfully'));
        }
    }

    public function check_in(Request $request,$id)
    {
        $visitor = Visitor::where('visitorID', $id)->first();
        $visitor->status = $request['status'];
        $visitor->checkin = date('h:i A');
        $visitor->date = date('d-m-Y');
        $visitor->save();

        if(setting('notifications_email') == 1){
            event(new VisitorCheckedIn($visitor));

        }

        if (setting('notifications_sms') == 1){
            event(new SendSmsVisitorHost($visitor->host));
        }

        if ($visitor) {
            return redirect(route('admin.visitors'))->with('success', trans('Update Successfully'));
        }
    }

    public function check_out(Request $request)
    {
        $visitor = Visitor::where('visitorID', $request['visitor_ID'])->first();
        
        if ($visitor != null) {
            $visitor->status = $request['status'];
            $visitor->checkout = date('h:i A');
            $visitor->date = date('d-m-Y');
            $visitor->save();
            return redirect(route('admin.visitors'))->with('success', trans('Update Successfully'));
        } else {
            return redirect(route('admin.visitors'))->with('error', trans('Visitor Not Found'));
        }
    }

    public function destroy($id)
    {
        $result = Visitor::destroy($id);
        if ($result) {
            return redirect(route('admin.visitors'))->with('success', trans('Delete Successfully'));
        }
    }

    public function datevalue(Request $request)
    {
        $date = $request['date'];
        $perPage = 25;
        if ($request['date']) {
            $visitors = Visitor::whereBetween('date', [$date, $date])->latest()->paginate($perPage);
        } else {
            $visitors = Visitor::latest()->paginate($perPage);
        }
        return view('admin.visitors.index', compact('visitors'));
    }

    public function export(Request $request)
    {
        $date = $request['date'];
        $date = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate = date('d-m-Y', strtotime($date[1]));

        $data = array();

        if ($request['date']) {
            $items = Visitor::whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $items = Visitor::all();
        }

        foreach ($items as $key => $value) {
            $data[$key]['ID'] = $key + 1;
            $data[$key]['Name'] = $value->first_name . ' ' . $value->last_name;
            $data[$key]['Email'] = $value->email;
            $data[$key]['Phone'] = $value->phone;
            $data[$key]['Company name'] = $value->company_name;
            $data[$key]['Date'] = $value->date;
            $data[$key]['Host name'] = $value->host_name;
            $data[$key]['VisitorsID'] = $value->visitorID;
            if ($value->status == 1) {
                $data[$key]['Status'] = 'Check Out';
            } elseif ($value->status == 2) {
                $data[$key]['Status'] = 'Check in';
            }
        }

        Excel::create('visitors', function ($excel) use ($data) {
            $excel->sheet('ExportFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

        return redirect('admin/visitors');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendEmail(Request $request)
    {
        $date = $request['date'];
        $date = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate = date('d-m-Y', strtotime($date[1]));

        $data = array();

        if ($request['date']) {
            $items = Visitor::whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $items = Visitor::all();
        }

        foreach ($items as $key => $value) {
            $data[$key]['ID'] = $key + 1;
            $data[$key]['Name'] = $value->first_name . ' ' . $value->last_name;
            $data[$key]['Email'] = $value->email;
            $data[$key]['Phone'] = $value->phone;
            $data[$key]['Company name'] = $value->company_name;
            $data[$key]['Date'] = $value->date;
            $data[$key]['Host name'] = $value->host_name;
            $data[$key]['VisitorsID'] = $value->visitorID;
            if ($value->status == 1) {
                $data[$key]['Status'] = 'Check Out';
            } elseif ($value->status == 2) {
                $data[$key]['Status'] = 'Check in';
            }
        }

        $file = Excel::create('visitors', function ($excel) use ($data) {
            $excel->sheet('ExportFile', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->save('xls', storage_path('excel/exports'), true);

        Mail::to($request->user())->send(new VisitorListExcel($request, $file['full']));

        return redirect('admin/visitors');
    }

}
