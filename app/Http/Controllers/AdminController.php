<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classes;
use App\Models\student;
use App\Models\Fees;
use Carbon\Carbon;
use DateTime;
use DB;
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
        if ($request->depositDateValue == null) {
            return response()->json(['error' => 'Please Select A Valid Deposit Date ! Can Not Accept Null Value ']);
        }
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

    public function searchRecords(Request $request) {
        $query = $request->input('query');
        $results = student::leftJoin('fees', 'students.id', '=', 'fees.student_id')
        ->select('students.id', 'students.name', 'students.age', 'students.class',  \DB::raw('DATE_FORMAT(MAX(fees.deposit_date), "%d/%m/%Y") as last_deposit_date'))
        ->where('name', 'like', '%' . $query . '%')
        ->orwhere('age', 'like', '%' . $query . '%')
        ->orwhere('class', 'like', '%' . $query . '%')
        ->groupBy('students.id', 'students.name', 'students.age', 'students.class')
        ->get();
        return response()->json(['results' => $results]);
    }

    public function deleteStudent($id) {
        $studen_record = student::find($id);
        if (!$studen_record) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        $fee_structure = Fees::where('student_id','=',$id)->get();
        $studen_record->delete();
        foreach ($fee_structure as $fee) {
            $fee->delete();
        }
        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function deleteFeeRecord($id) {
        $fee_record = Fees::find($id);
        if (!$fee_record) {
            return response()->json(['error' => 'Fees Record not found'], 404);
        }
        $currentDate = Carbon::now();
        $dueDate = Carbon::parse($fee_record->due_date);
        if ($dueDate->month == $currentDate->subMonth()->month || $dueDate->year == $currentDate->subYear()->year) {
            return response()->json(['message' => 'Cannot delete fee record with due date from last month or year']);
        }
        $fee_record->delete();
        return response()->json(['message' => 'Fees Record is being deleted successfully']);
    }


    public function date_filter(Request $request) {
        $student_id = $request->currentStudentId;
        $selected_data = $request->selectedDate;    
        $selected_date = Carbon::parse($selected_data);

        $fees = Fees::where('student_id', $student_id)
                ->whereYear('due_date', $selected_date->year)
                ->whereMonth('due_date', $selected_date->month)
                ->get();
        return response()->json(['message' => 'Data Fetched successfully', 'fees' => $fees]); 
    }
}
