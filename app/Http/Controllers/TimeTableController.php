<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class TimeTableController extends Controller
{
    public function timeTable(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'no_of_working_days' => 'required|numeric|max:7|min:1',
            'no_of_subjects_days' => 'required|numeric|max:8|min:1',
            'total_subjects' => 'required|numeric|max:9|',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        $noOfWorkingDays = $request->no_of_working_days;
        $noOfSubjectDays = $request->no_of_subjects_days;
        $totalSubjects = $request->total_subjects;
        $totaWeeklHours = $noOfWorkingDays * $noOfSubjectDays;
        $week = [1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday'];
        $subjecHourstData = $request->subject_data;
        $subjectData = [];
        if(!empty($subjecHourstData)){
            foreach($subjecHourstData as $row){
                $string = str_repeat($row['subject'].',',$row['hours']);
                $string = rtrim($string, ', ');
                $subjectData[] = explode(',',$string);
            }
        }
        $subjectData = array_chunk(\Arr::flatten($subjectData),$noOfWorkingDays);
        $subjectData = !empty($subjectData) ? array_filter($subjectData) : null;
        $data = ['totalSubjects'=>$totalSubjects,'totaWeeklHours'=>$totaWeeklHours,'noOfWorkingDays'=>$noOfWorkingDays,'week'=>$week,'subjectData'=>$subjectData];
        return redirect()->back()->withInput()->with('data',$data);
    }
}
