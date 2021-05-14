<?php

namespace App\Http\Controllers;

use App\Models\ClassAttendance;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class ClassAttendancesController extends Controller
{
    public function store(Request $request) {

        $fields = $request->validate([
            'subject_id' => 'required',
            'date' => 'required|date'
        ]);

        $user = auth()->user();

        $subject = Subject::where([
            'id' => $fields['subject_id'],
            'user_id' => $user->id
        ])->first();

        if(!$subject) {
            return response([
                'message' => 'No Subject with the given ID'
            ], 404);
        }

        $attendance = ClassAttendance::where([
            'subject_id' => $subject->id,
            'date' => $fields['date']
        ])->first();

        if($attendance) {
            return response([
                'message' => 'Already have an attendance of this date'
            ], 422);
        }

        $class = ClassAttendance::create([
            'subject_id' => $fields['subject_id'],
            'date' => $fields['date'],
            'status' => 'open'
        ]);

        return response([
            'message' => 'New Attendance is opened',
            'class_attendance' => $class
        ], 201);
    }
}
