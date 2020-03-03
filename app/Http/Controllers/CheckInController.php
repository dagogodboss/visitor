<?php

namespace App\Http\Controllers;

use App\Events\SendSmsVisitorHost;
use App\Events\VisitorCheckedIn;
use App\Managers\CheckInManager;
use App\Managers\EmployeeManager;
use App\Models\PreRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckInController extends Controller
{
    protected $employeeManager;
    protected $checkInManager;

    function __construct(EmployeeManager $employeeManager, CheckInManager $checkInManager)
    {
        $this->employeeManager = $employeeManager;
        $this->checkInManager  = $checkInManager;
    }

    public function index()
    {
        session()->forget('visitor');
        return view('check-in.dashboard');
    }

    /**
     * Show the step 1 Form for creating a new product.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createStepOne(Request $request)
    {
        $employees = $this->employeeManager->getEmployees();
        $visitor   = $request->session()->get('visitor');
        return view('check-in.create-step-one', compact('visitor', 'employees'));
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepOne(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'   => 'required',
            'last_name'    => 'required',
            'company_name' => '',
            'email'        => 'required',
            'phone'        => 'required',
            'host_id'      => 'required|numeric',
        ]);

        if (empty($request->session()->get('visitor'))) {
            $visitor = $this->checkInManager->setVisitor($validatedData);
            $request->session()->put('visitor', $visitor);
        } else {
            $visitor = $request->session()->get('visitor');
            $visitor->fill($validatedData);
            $request->session()->put('visitor', $visitor);
        }

        return redirect()->route('check-in.step-two');
    }

    /**
     * Show the step 2 Form for creating a new product.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createStepTwo(Request $request)
    {
        $visitor = $request->session()->get('visitor');
        return view('check-in.create-step-two', compact('visitor'));
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepTwo(Request $request)
    {
        $visitor = $request->session()->get('visitor');
        if($request->has('photo')) {
            $request->validate([
                'photo' => 'required',
            ]);

            $encoded_data = $request['photo'];
            $image = str_replace('data:image/png;base64,', '', $encoded_data);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            Storage::disk('public')->put('img/'.$imageName, base64_decode($image));

            $visitor = $request->session()->get('visitor');

            $visitor->photo = $imageName;
            $request->session()->put('visitor', $visitor);
        }
        return redirect('/run-fast');
    }

    /**
     * Show the Product Review page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createStepThree(Request $request)
    {
        $visitor = $request->session()->get('visitor');
        return view('check-in.create-step-three', compact('visitor'));
    }

    /**
     * Store product
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (setting('visitor_agreement') == 1) {
            $request->validate([
                'agreement' => 'required',
            ]);
            session()->put('agreement', $request->get('agreement'));
        }

        $visitor = $this->checkInManager->store($request);
        if($visitor) {
            if($request->get('emailCheck') == 'on'){
                event(new VisitorCheckedIn($visitor));
            }

            if (setting('notifications_sms') == 1){
                event(new SendSmsVisitorHost($visitor->host));
            }
            return redirect()->route('check-in.show', $visitor->id);
        }
    }

    public function show($id)
    {
        $visitor = $this->checkInManager->getById($id);

        if($visitor) {
            return view('check-in.show', compact('visitor'));
        } else {
            return redirect('/check-in');
        }

    }

    public function visitor_return()
    {
        return view('check-in.return');
    }

    public function pre_registered()
    {
        return view('check-in.pre_registered');
    }

    public function find_visitor(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:visitors,email',
        ]);

        $return_visitor = $this->checkInManager->getByEmail($request->get('email'));
        if(!empty($return_visitor)) {
            $current_visitor = [
                "first_name"    => $return_visitor->first_name,
                "last_name"     => $return_visitor->last_name,
                "email"         => $return_visitor->email,
                "phone"         => $return_visitor->phone,
                "company_name"  => $return_visitor->company_name,
                "host_id"       => $return_visitor->host_id,
                "photo"         => $return_visitor->photo,
            ];
            $visitor = $this->checkInManager->setVisitor($current_visitor);
            $request->session()->put('visitor', $visitor);
            return redirect()->route('check-in.step-two');
        }
        return redirect()->route('check-in.return')->with('errors', "Visitor not found!");
    }

    public function find_pre_visitor(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:pre_registers,email',
        ]);
        $pre_registered_visitor = PreRegister::where('email',$request['email'])->first();

        if(!empty($pre_registered_visitor)) {
            $current_visitor = [
                "first_name"    => $pre_registered_visitor->first_name,
                "last_name"     => $pre_registered_visitor->last_name,
                "email"         => $pre_registered_visitor->email,
                "phone"         => $pre_registered_visitor->phone,
                "company_name"  => $pre_registered_visitor->company_name,
                "host_id"       => $pre_registered_visitor->host_id
            ];
            $visitor = $this->checkInManager->setVisitor($current_visitor);
            $request->session()->put('visitor', $visitor);
            return redirect()->route('check-in.step-two');
        }
        return redirect()->route('check-in.pre.registered')->with('errors', "Visitor not found!");
    }
}