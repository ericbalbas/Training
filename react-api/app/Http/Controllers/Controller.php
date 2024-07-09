<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        $students = Student::all(); // fetch all data;

        if(!$students->count()){
            return response()->json([
                'status'    => 400,
                'students'  => 'No records Here!!',
            ], 400);
        }

        return response()->json([
            'status'    => 200,
            'students'  => $students,
        ], 200);

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email'  => 'required|email',
            'phone'  => 'required|digits:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'mssg'   => $validator->messages(),
            ], 422);
        }

        $student = Student::create([
            'name'   => $request->name,
            'course' => $request->course,
            'email'  => $request->email,
            'phone'  => $request->phone,
        ]);

        if(!$student){
            return response()->json([
                'status' => 500,
                'mssg'   => 'Something Went wrong!',
            ], 500);
        }

        return
        response()->json([
            'status' => 201,
            'mssg'   => 'Created successfully!',
        ], 201);
    }

    public function show($id){
        $student = Student::find($id);

        if(!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => $student,
        ]);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found.',
            ],404);
        }

        return response()->json([
            'status' => 200,
            'message' => $student,
        ],200);
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email'  => 'required|email',
            'phone'  => 'required|digits:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'mssg'   => $validator->messages(),
            ], 422);
        }

        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'mssg'   => 'No such student found.',
            ], 404);
        }

        $student->update([
            'name'   => $request->name,
            'course' => $request->course,
            'email'  => $request->email,
            'phone'  => $request->phone,
        ]);

        return
            response()->json([
                'status' => 200,
                'mssg'   => 'Student updated successfully!',
            ], 201);
    }

    public function destroy($id){

        $student = Student::find($id);

        if(!$student){
            return response()->json([
                'status' => 404,
                'mssg'   => 'No such student found.',
            ], 404);
        }

        $student->delete();
        return response()->json([
                'status' => 200,
                'mssg'   => 'Student deleted successfully',
            ], 200);
    }


}
