<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\User;
use App\Models\Employee;
use App\Models\PreRegister;
use App\Models\Employee_check;
use App\Events\AdminReptionEmail;
use App\Setting;
use App\Events\SendSmsAdminRecption;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DB;
use Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;




class EmployeesController extends Controller
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
            if (!empty($keyword)) {
                $employees = User::where('name', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->latest()->whereHas('roles', function($q) {
                        $q->whereIn('name', ['employee'] );
                    })->paginate($perPage);
            } else {
                $employees = User::latest()->whereHas('roles', function($q) {
                    $q->whereIn('name', ['employee'] );
                })->paginate($perPage);
            }
            return view('admin.employees.index', compact('employees'));

        } elseif (auth()->user()->isAdmin() == 'employee'){

            $id = auth()->user()->id;
            $perPage = 25;
            $visitors = Visitor::where('host_id',$id)->latest()->paginate($perPage);
            return view('admin.employees.dashboard', compact('visitors'));
        } else{
            abort(403, 'Unauthorized action.');
        }


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $employee = Null;
        return view('admin.employees.create',compact('employee'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required|max:50',
                'email' => 'required|string|max:50|email|unique:users',
                'phone' => 'required|string|max:15',
                'department' => 'required|string|max:100',
                'password' => 'required',
            ]
        );
        $userData = $request->except('password');
        $userData['password'] = Hash::make($request->password);

        $user= new User();
        $user->name         =    $userData['name'];
        $user->email        =    $userData['email'];
        $user->password     =    $userData['password'];
        $user->save();
        $user->roles()->attach(3);

        //Employees Add ================================>
        if($userData){
            $employ =  DB::table('employees')->orderBy('employeeID', 'desc')->first();

            $date   =   date('y-m-d');
            $data   =  substr($date,0,2);
            $data1  =  substr($date,3,2);
            $data2  =  substr($date,6,8);

            if($employ) {
                $value = substr($employ->employeeID, -2);
                if($value <1000){
                    $employeeID = $data.$data2.$data1.$value+1;
                } else{
                    $employeeID = $data.$data2.$data1.'01';
                }
            } else {
                $employeeID = $data.$data2.$data1.'01';
            }
            if (!empty($request['photo'])) {
                $encoded_data = $request['photo'];
                $data = substr($encoded_data,5,9);
                if($data =='image/png'){
                    $image = str_replace('data:image/png;base64,', '', $encoded_data);
                }else{
                    $image = str_replace('data:image/jpeg;base64,', '', $encoded_data);
                }
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.'png';
                Storage::disk('public')->put('images/'.$imageName, base64_decode($image));
            } else {
                $imageName = null;
            }

            $employee= new Employee();
            $employee->phone                    = $request['phone'];
            $employee->department               = $request['department'];
            $employee->photo                    = $imageName;
            $employee->date                     = date('d-m-Y');
            $employee->employeeID               = $employeeID;
            $employee->user_id                  = $user->id;

            $employee = $employee->save();
        }

        if($employee){
            return redirect('admin/employees')->with('flash_message', 'Employee added!');
        }

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
        $employee = User::find($id);
        $attendance = Employee_check::where('employee_id',$id)->get();
        return view('admin.employees.show', compact('employee','attendance'));
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
        $employee = User::find($id);
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate(
            $request,
            [
                'email' => 'required|string|max:255|email|unique:users,email,' .$user->id,
            ]
        );
        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->name         =    $data['name'];
        $user->email        =    $data['email'];
        if($data['password']){
            $user->password     =    $data['password'];
        }

         $user->save();


        //Employees ================================>
        if($user){
            if (!empty($request['photo'])) {
                $encoded_data = $request['photo'];
                $data = substr($encoded_data,5,9);
                if($data =='image/png'){
                    $image = str_replace('data:image/png;base64,', '', $encoded_data);
                } else {
                    $image = str_replace('data:image/jpeg;base64,', '', $encoded_data);
                }
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.'png';
                Storage::disk('public')->put('images/'.$imageName, base64_decode($image));
            } else {
                $imageName = null;
            }


            $employee = Employee::findOrFail($user->employee->id);
            $employee->phone                    = $request['phone'];
            $employee->department               = $request['department'];
            if($request['photo']) {
                $employee->photo                = $imageName;
            }
            $employee->date                     = date('d-m-Y');

            $employee->save();

        }

        return redirect('admin/employees')->with('flash_message', 'Employee updated!');
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
        User::destroy($id);

        return redirect('admin/employees')->with('flash_message', 'Employee deleted!');
    }


    public function visitor_show($id)
    {
        $host_id = auth()->user()->id;
        $visitor = Visitor::findOrFail($id);
        if($visitor->host_id == $host_id){
            $settings = Setting::all();
            return view('admin.employees.visitor_show', compact('visitor','settings'));
        }else{
            $visitor =null;
            $settings = Setting::all();
            return view('admin.employees.visitor_show', compact('visitor','settings'));
        }
    }

    public function profile()
    {
        $id = auth()->user()->id;
        if($id){
            $employee = User::findOrFail($id);
            return view('admin.employees.profile', compact('employee'));
        }else{
            return redirect('employees/dashboard');
        }

    }

    public function profile_edit($id)
    {
        if(auth()->user()->id == $id){
            $employee = User::findOrFail($id);

            return view('admin.employees.editProfile', compact('employee'));
        }else{
            return redirect('employees/dashboard');
        }
    }

    public function attendance()
    {

        $id = auth()->user()->id;
        if($id){
            $attendance = Employee_check::where('employee_id',$id)->get();

            return view('admin.employees.attendance', compact('attendance'));
        }else{
            return redirect('employees/dashboard');
        }
    }

    public function ProfileUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate(
            $request,
            [
                'email' => 'required|string|max:255|email|unique:users,email,' .$user->id,
            ]
        );
        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->name         =    $data['name'];
        $user->email        =    $data['email'];
        if($data['password']){
            $user->password     =    $data['password'];
        }

        $user->save();

        //Employees ================================>
        if($user){
            $encoded_data = $request['photo'];
            $data = substr($encoded_data,5,9);
            if($data =='image/png'){
                $image = str_replace('data:image/png;base64,', '', $encoded_data);
            }else{
                $image = str_replace('data:image/jpeg;base64,', '', $encoded_data);
            }
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            Storage::disk('public')->put('img/'.$imageName, base64_decode($image));

            $employee = Employee::findOrFail($user->employee->id);

            $employee->phone                    = $request['phone'];
            $employee->department               = $request['department'];
            if($request['photo']){
                $employee->photo                    = $imageName;
            }
            $employee->date                     = date('d-m-Y');

            $employee->save();
            return redirect('employees/profile')->with('flash_message', 'Profile updated!');
        }else{
            return redirect('employees/dashboard');
        }
    }



    public function checkin_out(Request $request,$id)
    {
        $employeeID = User::find($id);

        if($request['status'] == 2){
            $checkin = new Employee_check();
            $checkin->employee_id            = $id;
            $checkin->status                 = $request['status'];
            $checkin->checkin                = date('h:i A');
            $checkin->date                   = date('d-m-Y');
            $checkin->save();

            $employee = Employee::find($employeeID->employee->id);
            $employee->status                 = $request['status'];
            $employee->save();
            if($checkin){
                return redirect('employees/profile')->with('success', trans('Successfully'));
            }
        }elseif ($request['status'] == 1){

            $employeeID = User::find($id);
            $employee_check = Employee_check::where('employee_id',$id)->first();
            $checkout = Employee_check::find($employee_check->id);
            $checkout->status                 = $request['status'];
            $checkout->checkout                = date('h:i A');
            $checkout->date                     = date('d-m-Y');
            $checkout->save();

            $employee = Employee::find($employeeID->employee->id);
            $employee->status                 = $request['status'];
            $employee->save();
            if($checkout){
                return redirect('employees/profile')->with('success', trans('Successfully'));
            }
        }

    }

   public function check_in(Request $request,$id)
    {
        $employeeID = User::find($id);

        $checkin = new Employee_check();
        $checkin->employee_id            = $id;
        $checkin->status                 = $request['status'];
        $checkin->checkin                = date('h:i A');
        $checkin->date                   = date('d-m-Y');
        $checkin->save();

        $employee = Employee::find($employeeID->employee->id);
        $employee->status                 = $request['status'];
        $employee->save();
        if($checkin){
            return redirect('admin/employees')->with('success', trans('Update Successfully'));
        }
    }
    public function check_out(Request $request,$id)
    {

        $employeeID = User::find($id);
        $employee_check = Employee_check::where('employee_id',$id)->first();
        $checkout = Employee_check::find($employee_check->id);
        $checkout->status                 = $request['status'];
        $checkout->checkout                = date('h:i A');
        $checkout->date                     = date('d-m-Y');
        $checkout->save();

        $employee = Employee::find($employeeID->employee->id);
        $employee->status                 = $request['status'];
        $employee->save();
        if($checkout){
            return redirect('admin/employees')->with('success', trans('Update Successfully'));
        }
    }






    public function pre_register()
    {
        $id = auth()->user()->id;
        $perPage = 25;
        $pre_register = PreRegister::where('user_id',$id)->latest()->paginate($perPage);
        return view('admin.employees.pre_register', compact('pre_register'));
    }

    public function pre_register_create()
    {
        $employees    = User::latest()->whereHas('roles', function ($q) {
            $q->whereIn('name', ['employee']);
        })->pluck('name', 'id')->all();
        return view('admin.employees.pre_register_create', compact('employees'));

    }

    public function pre_register_store(Request $request)
    {
        $userID = auth()->user()->id;
        $visitor =  DB::table('pre_registers')->orderBy('visitorID', 'desc')->first();
        $date   =   date('y-m-d');
        $data  =  substr($date,0,2);
        $data1  =  substr($date,3,2);
        $data2  =  substr($date,6,8);

        if($visitor){
            $value = substr($visitor->visitorID, -2);
            if($value <1000){
                $visitorID = $data2.$data1.$data.$value+1;
            }else{
                $visitorID = $data2.$data1.$data.'01';
            }
        }else{
            $visitorID = $data2.$data1.$data.'01';
        }
        $id = $request['host_id'];
        $host = User::find($id);

        $pre_register = new PreRegister();
        $pre_register->first_name               = $request['first_name'];
        $pre_register->last_name                = $request['last_name'];
        $pre_register->email                    = $request['email'];
        $pre_register->company_name             = $request['company_name'];
        $pre_register->phone                    = $request['phone'];
        $pre_register->host_name                = $host->name;
        $pre_register->host_id                  = $host->id;
        $pre_register->visitorID                = $visitorID;
        $pre_register->date                     = date('d-m-Y');
        $pre_register->expected_date            = $request['expected_date'];
        $pre_register->expected_time            = $request['expected_time'];
        $pre_register->comment                  = $request['comment'];
        $pre_register->user_id                  = $userID;

        $pre_register->save();

        if($request['invite_visitor']=='on'){

            $email =$request['email'];
            $data = array(
                'name'          =>$request['first_name'],
                'email'         =>$request['email'],
                'company_name'  =>$request['company_name'],
                'phone'         =>$request['phone'],
                'host'          =>$request['host_name'],
                'visitorID'     =>$visitorID,
                'expected_date' =>$request['expected_date'],
                'expected_time' =>$request['expected_time'],
                'comment'       =>$request['comment'],
                'invite'        =>setting('invite_templates')
            );

            if(setting('notifications_email') == 1){
                $user = User::whereHas('roles', function (Builder $query) {
                    $query->where('name', 'reception')->orWhere('name', 'admin');
                })->get();
                event(new AdminReptionEmail($user,$pre_register));

            }

            if (setting('notifications_sms') == 1){
                $user = User::whereHas('roles', function (Builder $query) {
                    $query->where('name', 'reception')->orWhere('name', 'admin');
                })->get();
                event(new SendSmsAdminRecption($user,$pre_register));
            }

            Mail::send('admin.invite', $data, function($message) use ($email) {
                $message->to($email, 'Visitor New')->subject('Visitors Invite');
                $message->from(setting('site_email'),setting('site_name'));
            });
            return redirect('employees/pre-register')->with('flash_message', 'pre-register Mail send and added!');
        }else{
            return redirect('employees/pre-register')->with('flash_message', 'pre-register added!');
        }

    }

    public function pre_register_edit($id)
    {
        $pre_register = PreRegister::findOrFail($id);
        $employees    = User::latest()->whereHas('roles', function ($q) {
            $q->whereIn('name', ['employee']);
        })->pluck('name', 'id')->all();

        return view('admin.employees.pre_register_edit', compact('pre_register','employees'));
    }

    public function pre_register_update(Request $request, $id)
    {

        $userID = auth()->user()->id;

        $host_id = $request['host_id'];
        $host =  $employee = User::find($host_id);

        $pre_register = PreRegister::findOrFail($id);

        $pre_register->first_name               = $request['first_name'];
        $pre_register->last_name                = $request['last_name'];
        $pre_register->email                    = $request['email'];
        $pre_register->company_name             = $request['company_name'];
        $pre_register->phone                    = $request['phone'];
        $pre_register->host_name                = $host->name;
        $pre_register->host_id                  = $host->id;
        $pre_register->date                     = date('d-m-Y');
        $pre_register->expected_date            = $request['expected_date'];
        $pre_register->expected_time            = $request['expected_time'];
        $pre_register->comment                  = $request['comment'];
        $pre_register->user_id                  = $userID;


        $pre_register->save();
        if($request['invite_visitor']=='on') {
            $settings = Setting::all();

            $email = $request['email'];
            $data = array(
                'name' => $request['first_name'],
                'email' => $request['email'],
                'company_name' => $request['company_name'],
                'phone' => $request['phone'],
                'host' => $request['host_name'],
                'visitorID' => $pre_register->visitorID,
                'expected_date' => $request['expected_date'],
                'expected_time' => $request['expected_time'],
                'comment' => $request['comment'],
                'invite' => $settings[0]->invite_templates
            );

            Mail::send('admin.invite', $data, function ($message) use ($email) {
                $message->to($email, 'Visitor New')->subject
                ('Visitors Invite');
                $message->from('info@goschool.io', 'GoSchool');
            });
        }


        return redirect('employees/pre-register')->with('flash_message', 'pre-register updated!');
    }

    public function pre_register_destroy($id)
    {
        PreRegister::destroy($id);

        return redirect('employees/pre-register')->with('flash_message', 'pre-register deleted!');
    }


    public function datevalue(Request $request)
    {

        $date = $request['date'];
        $perPage =25;
        if($request['date']){
            $employees = Employee::with('user')->whereBetween('date',[$date,$date])->latest()->paginate($perPage);
        }else{
            $employees = User::latest()->whereHas('roles', function($q) {
                $q->whereIn('name', ['employee'] );
            })->paginate($perPage);
        }

        return view('admin.employees.index', compact('employees'));
    }


    public function export(Request $request)
    {

        $date = $request['date'];
        $date = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate = date('d-m-Y', strtotime($date[1]));

        $data = array();

        if($request['date']){
            $items = Employee::with('user')->whereBetween('date',[$startDate,$endDate])->get();
        }else{
            $items = User::latest()->whereHas('roles', function($q) {
                $q->whereIn('name', ['employee'] );
            });
        }

        foreach ($items as $key => $value)
        {
            if(!empty($value->user)) {
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
        }

        Excel::create('Employee', function($excel) use($data) {
            $excel->sheet('ExportFile', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');

        return redirect('admin/employees');

    }

    public function sendEmail(Request $request)
    {

        $date = $request['date'];
        $date = explode('-', $date);
        $startDate = date('d-m-Y', strtotime($date[0]));
        $endDate = date('d-m-Y', strtotime($date[1]));
        $data = array();
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

        $file = Excel::create('Employee',function($excel) use($data){
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

        if($request['to']){
            Mail::send('admin.employees.email', $dataemail, function($message) use ($dataemail) {
                $message->to($dataemail['to'])->subject($dataemail['subject']);
                $message->attach($dataemail['file']);
                $message->from(setting('site_email'), setting('site_name'));
            });
        }
        return redirect('admin/employees');
    }

}
