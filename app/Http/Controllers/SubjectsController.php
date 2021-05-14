<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();

        return response([
            'subjects' => $subjects
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|unique:subjects'
        ]);

        $user = auth()->user();

        $subject = Subject::create([
            'name' => $fields['name'],
            'user_id' => $user->id
        ]);

        return response([
            'subject' => $subject
        ], 201);
    }

    public function show($id)
    {
        $subject = Subject::where('id', $id)->first();

        return response([
            'subject' => $subject
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $subject = Subject::where('id', $id)->delete();

        if(!$subject) {
            return response([
                'message' => 'Could not delete the subject'
            ], 500);
        }

        return response([
            'message' => 'Subject deleted'
        ], 200);
    }

    public function subjectsByUser() {
        $user = auth()->user();

        $subjects = Subject::where('user_id', $user->id)->get();

        return response([
            'subjects' => $subjects
        ], 200);
    }
}
