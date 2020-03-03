<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Visitor;
use App\Models\Employee;
use App\Models\PreRegister;
use App\User;
use DB;
use Excel;
use Mail;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if(auth()->user()->isAdmin() == 'admin'){
            $keyword = $request->get('search');
            $perPage = 25;

            if($request['all'] =='Visitors'){
                if (!empty($keyword)) {
                    $visitors = Visitor::where('first_name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%")
                        ->orWhere('phone', 'LIKE', "%$keyword%")
                        ->orWhere('company_name', 'LIKE', "%$keyword%")
                        ->orWhere('last_name', 'LIKE', "%$keyword%")
                        ->latest()->paginate($perPage);

                    $employees = User::latest()->whereHas('roles', function($q) {
                        $q->whereIn('name', ['employee'] );
                    })->paginate($perPage);

                    $pre_registers = PreRegister::latest()->paginate($perPage);

                } else {
                    $visitors = Visitor::latest()->paginate($perPage);
                }
            }elseif ($request['all'] =='Employees'){
                if (!empty($keyword)) {
                    $employees = User::where('name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%")
                        ->latest()->whereHas('roles', function($q) {
                            $q->whereIn('name', ['employee'] );
                        })->paginate($perPage);

                    $visitors = Visitor::latest()->paginate($perPage);
                    $pre_registers = PreRegister::latest()->paginate($perPage);
                } else {
                    $employees = User::latest()->whereHas('roles', function($q) {
                        $q->whereIn('name', ['employee'] );
                    })->paginate($perPage);
                }

            }elseif ($request['all'] =='pre_registers'){
                if (!empty($keyword)) {
                    $pre_registers = PreRegister::where('first_name', 'LIKE', "%$keyword%")
                        ->orWhere('last_name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%")
                        ->orWhere('phone', 'LIKE', "%$keyword%")
                        ->orWhere('company_name', 'LIKE', "%$keyword%")
                        ->latest()->paginate($perPage);
                    $visitors = Visitor::latest()->paginate($perPage);
                    $employees = User::latest()->whereHas('roles', function($q) {
                        $q->whereIn('name', ['employee'] );
                    })->paginate($perPage);

                } else {
                    $pre_registers = PreRegister::latest()->paginate($perPage);
                }
            }else{
                $visitors = Visitor::latest()->paginate($perPage);
                $employees = User::latest()->whereHas('roles', function($q) {
                    $q->whereIn('name', ['employee'] );
                })->paginate($perPage);

                $pre_registers = PreRegister::latest()->paginate($perPage);
            }
            $allCounts =[];

            $allCounts['0'] = DB::table('visitors')->count();
            $allCounts['1'] = DB::table('employees')->count();
            $allCounts['2'] = DB::table('pre_registers')->count();

            return view('admin.dashboard',compact('visitors','employees','pre_registers','allCounts'));
        }else{
            abort(404, 'Unauthorized action.');
        }

    }

    public function profile()
    {
        $id = auth()->user()->id;
        if($id){
            $profile = User::findOrFail($id);
            return view('admin.profile', compact('profile'));
        }else{
            return redirect('admin/dashboard');
        }

    }

    public function destroy(Request $request, $id)
    {
        if($request['all'] =='Visitors'){

            $result = Visitor::destroy($id);

        }elseif ($request['all'] =='Employees'){
            $result = User::destroy($id);

        }elseif ($request['all'] =='pre_registers'){
            $result = PreRegister::destroy($id);
        }

        if ($result) {
            return redirect(route('admin'))->with('success', trans('Delete Successfully'));
        }
    }

    public function sendEmail(Request $request)
    {

        $date = $request['date'];
        $date = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate = date('d-m-Y', strtotime($date[1]));
        $data = array();

        if($request['all'] =='Visitors'){

            if($request['date']){
                $items = Visitor::whereBetween('date', [$startDate, $endDate])->get();
            }else{
                $items = Visitor::all();
            }
            foreach ($items as $key => $value)
            {
                $data[$key]['ID']           =$key+1;
                $data[$key]['Name']         =$value->first_name. ' ' .$value->last_name;
                $data[$key]['Email']        =$value->email;
                $data[$key]['Phone']        =$value->phone;
                $data[$key]['Company name'] =$value->company_name;
                $data[$key]['Date']         =$value->date;
                $data[$key]['Host name']    =$value->host_name;
                $data[$key]['VisitorsID']   =$value->visitorID;
                if($value->status == 0){
                    $data[$key]['Status']   ='Check Out';
                }elseif ($value->status == 1){
                    $data[$key]['Status']   ='Check in';
                }
            }

            $file = Excel::create('visitors',function($excel) use($data){
                $excel->sheet('ExportFile',function($sheet) use($data){
                    $sheet->fromArray($data);
                });
            })->save('xls', storage_path('excel/exports'), true);

            $dataemail = array(
                'to' => $request['to'],
                'subject' => $request['subject'],
                'file' => $file['full'],
                'body' => $request['body'],
            );

            Mail::send('admin.visitors.email', $dataemail, function($message) use ($dataemail) {
                $message->to($dataemail['to'])->subject
                ($dataemail['subject']);
                $message->attach($dataemail['file']);
                $message->from('info@goschool.io', 'GoSchool');
            });


        }elseif($request['all'] =='Employees'){

            if($request['date']){
                $items = Employee::with('user')->whereBetween('date',[$startDate,$endDate])->get();
            }else{
                $items = User::latest()->whereHas('roles', function($q) {
                    $q->whereIn('name', ['employee'] );
                });
            }

            foreach ($items as $key => $value)
            {
                $data[$key]['ID']           =$key+1;
                $data[$key]['Name']         =$value->user->name;
                $data[$key]['Email']        =$value->user->email;
                $data[$key]['Phone']        =$value->phone;
                $data[$key]['Date']         =$value->date;
                $data[$key]['Department']   =$value->department;
                $data[$key]['EmployeeID']   =$value->employeeID;
                if($value->status == 1){
                    $data[$key]['Status']   ='Check Out';
                }elseif ($value->status == 2){
                    $data[$key]['Status']   ='Check in';
                }
            }

            $file = Excel::create('Employeelist',function($excel) use($data){
                $excel->sheet('ExportFile',function($sheet) use($data){
                    $sheet->fromArray($data);
                });
            })->save('xls', storage_path('excel/exports'), true);

            $dataemail = array(
                'to' => $request['to'],
                'subject' => $request['subject'],
                'file' => $file['full'],
                'body' => $request['body'],
            );

            Mail::send('admin.employees.email', $dataemail, function($message) use ($dataemail) {
                $message->to($dataemail['to'])->subject
                ($dataemail['subject']);
                $message->attach($dataemail['file']);
                $message->from('info@goschool.io', 'GoSchool');
            });

        }elseif($request['all'] =='pre_registers'){

            if($request['date']){
                $items = PreRegister::whereBetween('date', [$startDate, $endDate])->get();
            }else{
                $items = PreRegister::all();
            }
            foreach ($items as $key => $value)
            {
                $data[$key]['ID']           =$key+1;
                $data[$key]['Name']         =$value->first_name;
                $data[$key]['Email']        =$value->email;
                $data[$key]['Phone']        =$value->phone;
                $data[$key]['Company name'] =$value->company_name;
                $data[$key]['Date']         =$value->date;
                $data[$key]['Host name']    =$value->host_name;
                $data[$key]['VisitorsID']   =$value->visitorID;
                if($value->status == 0){
                    $data[$key]['Status']   ='Check Out';
                }elseif ($value->status == 1){
                    $data[$key]['Status']   ='Check in';
                }
            }

            $file = Excel::create('pre_registerlist',function($excel) use($data){
                $excel->sheet('ExportFile',function($sheet) use($data){
                    $sheet->fromArray($data);
                });
            })->save('xls', storage_path('excel/exports'), true);

            $dataemail = array(
                'to' => $request['to'],
                'subject' => $request['subject'],
                'file' => $file['full'],
                'body' => $request['body'],
            );


            Mail::send('admin.pre_register.email', $dataemail, function($message) use ($dataemail) {
                $message->to($dataemail['to'])->subject
                ($dataemail['subject']);
                $message->attach($dataemail['file']);
                $message->from('info@goschool.io', 'GoSchool');
            });
        }

        return redirect('admin');
    }

    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
            $date = $request['date'];
            $date = explode('-', $date);
            $startDate = date('d-m-Y', strtotime($date[0]));
            $endDate = date('d-m-Y', strtotime($date[1]));
            $data = array();

            if($request['all'] =='Visitors'){

                if($request['date']){
                    $items = Visitor::whereBetween('date', [$startDate, $endDate])->get();
                }else{
                    $items = Visitor::all();
                }

                foreach ($items as $key => $value)
                {
                    $data[$key]['ID']           =$key+1;
                    $data[$key]['Name']         =$value->first_name. ' ' .$value->last_name;
                    $data[$key]['Email']        =$value->email;
                    $data[$key]['Phone']        =$value->phone;
                    $data[$key]['Company name'] =$value->company_name;
                    $data[$key]['Date']         =$value->date;
                    $data[$key]['Host name']    =$value->host_name;
                    $data[$key]['VisitorsID']   =$value->visitorID;
                    if($value->status == 0){
                        $data[$key]['Status']   ='Check Out';
                    }elseif ($value->status == 1){
                        $data[$key]['Status']   ='Check in';
                    }
                }

            }elseif($request['all'] =='Employees'){


                if($request['date']){
                    $items = Employee::with('user')->whereBetween('date',[$startDate,$endDate])->get();
                }else{
                    $items = User::latest()->whereHas('roles', function($q) {
                        $q->whereIn('name', ['employee'] );
                    });
                }

                foreach ($items as $key => $value)
                {
                    $data[$key]['ID']           =$key+1;
                    $data[$key]['Name']         =$value->user->name;
                    $data[$key]['Email']        =$value->user->email;
                    $data[$key]['Phone']        =$value->phone;
                    $data[$key]['Date']         =$value->date;
                    $data[$key]['Department']   =$value->department;
                    $data[$key]['EmployeeID']   =$value->employeeID;
                    if($value->status == 1){
                        $data[$key]['Status']   ='Check Out';
                    }elseif ($value->status == 2){
                        $data[$key]['Status']   ='Check in';
                    }
                }

            }elseif($request['all'] =='pre_registers'){

                if($request['date']){
                    $items = PreRegister::whereBetween('date', [$startDate, $endDate])->get();
                }else{
                    $items = PreRegister::all();
                }
                foreach ($items as $key => $value)
                {
                    $data[$key]['ID']           =$key+1;
                    $data[$key]['Name']         =$value->first_name;
                    $data[$key]['Email']        =$value->email;
                    $data[$key]['Phone']        =$value->phone;
                    $data[$key]['Company name'] =$value->company_name;
                    $data[$key]['Date']         =$value->date;
                    $data[$key]['Host name']    =$value->host_name;
                    $data[$key]['VisitorsID']   =$value->visitorID;
                    if($value->status == 0){
                        $data[$key]['Status']   ='Check Out';
                    }elseif ($value->status == 1){
                        $data[$key]['Status']   ='Check in';
                    }
                }
            }

        Excel::create($request['all'], function($excel) use($data) {
            $excel->sheet('ExportFile', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

        return redirect('admin');

    }
}
