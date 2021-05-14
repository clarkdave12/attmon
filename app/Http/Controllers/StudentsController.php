<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'subject_id' => 'required',
            'id_number' => 'required'
        ]);

        $teacher = auth()->user();

        $subject = Subject::where([
            'id' => $fields['subject_id'],
            'user_id' => $teacher->id
        ])->first();

        if(!$subject) {
            return response([
                'message' => 'The user is not allowed in this subject'
            ], 405);
        }

        $student = User::where('id_number', $fields['id_number'])->first();

        if(!$student) {
            return response([
                'message' => 'No such Student with the given ID Number'
            ], 404);
        }

        $class = Student::create([
            'user_id' => $student->id,
            'subject_id' => $subject->id
        ]);

        return response([
            'message' => 'created',
            'student' => $student,
            'subject' => $subject
        ], 201);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($subjectId, $studentId)
    {
        $student = Student::where([
            'subject_id' => $subjectId,
            'user_id' => $studentId
        ])->first();

        if(!$student) {
            return response([
                'message' => 'Could not find student in class'
            ], 404);
        }

        $deleted = $student->delete();

        return response([
            'message' => 'deleted'
        ], 200);
    }
}
