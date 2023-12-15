<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classes;
use App\Models\student;
use App\Models\Fees;
use Carbon\Carbon;
use DateTime;
class AdminController extends Controller
{
    public function admin_pannel(){
        $classes = classes::all();
        return view('admin_pannel.index', compact('classes'));
    }

    function student_data(Request $request) {
        $student = new student;
        $students =$student->getStudentDataWithLastDeposit();
        return response()->json($students);
    }

    public function student_details(Request $request){
        $existingStudent = Student::where('name', $request->input('name'))
                ->where('class', $request->input('class'))
                ->first();
        if ($existingStudent) {
            return response()->json(['message' => 'Student with the same name and class already exists.'], 422);
        }
        $student = new student;
        $student->name = $request->name;
        $student->age  = $request->age;
        $student->class  = $request->class;
        $student->save();
        return response()->json(['message' => 'Student record added successfully.', 'student' => $student]);
    }

    public function add_fees(Request $request){
        $student_id = $request->currentStudentId;
        $date = Carbon::now()->toDateString();
        $curr_Date = Carbon::createFromFormat('Y-m-d', $date)->format('m/d/Y');
        $dueDate = Carbon::createFromFormat('Y-m-d', $request->due_on);
        $existingRecord = Fees::where('student_id', $student_id)
        ->whereYear('due_date',$dueDate->year)
        ->whereMonth('due_date', $dueDate->month)
        ->first();
        if ($existingRecord) {
            return response()->json(['error' => 'A record with the same student and due date already exists']);
        }
        if ($dueDate->isSameDay($date) || $dueDate->isPast()) {
            return response()->json(['message' => 'Due date must be for the next month or later']);
        }
        $fess = new Fees;
        $fess->student_id=$request->currentStudentId;
        $fess->amount = $request->amount;
        $fess->due_date = $request->due_on;
        $fess->save();
        return response()->json(['message' => 'Data saved successfully', 'fees' => $fess]);
    }
    public function fetchfees($studentId) {
        $fees = Fees::where('student_id',$studentId)->get();
        return response()->json(['message' => 'Data Fetched successfully', 'fees' => $fees]);
    }

    public function update_fees(Request $request){
        $id = $request->depositIdValue;
        $deposit_date = $request->depositDateValue;
        $student_id = $request->currentStudentId;
        $fess = Fees::where('id' ,$id)
                ->where('student_id',$student_id)
                ->first();
        if ($fess) {
            $new_deposit_date = new DateTime($deposit_date);
            $due_date = new DateTime($fess->due_date);
            if ($new_deposit_date < $due_date) {
                return response()->json(['error' => 'Deposit date cannot be before the due date']);
            }else{
                $fess->deposit_date = $deposit_date;
                $fess->status = '1';
                $fess->save();
                return response()->json(['message' => 'Fess Is being Deposited!']);
            }
        }else {
            return response()->json(['message' => 'Deposit record not found'], 404);
        }
    }

    public function login(){
        return view('login.login');
    }

    public function register(){
        return view('login.register');
    }

}
