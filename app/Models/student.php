<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class student extends Model
{
    use HasFactory;

    protected $fillable = ['name','age','class'];


    function getStudentDataWithLastDeposit() {
        $students = Student::leftJoin('fees', 'students.id', '=', 'fees.student_id')
                ->select('students.id', 'students.name', 'students.age', 'students.class',  \DB::raw('DATE_FORMAT(MAX(fees.deposit_date), "%d/%m/%Y") as last_deposit_date'))
                ->groupBy('students.id', 'students.name', 'students.age', 'students.class')
                ->get();
        return $students;
    }
}
