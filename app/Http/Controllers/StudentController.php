<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return response()->json($students, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'className' => 'required',
            'address' => 'required',
        ]);

        $student = new Student();

        $student->name = $request->name;
        $student->className = $request->className;
        $student->address = $request->address;
        $student->save();

        return response()->json('success', 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'className' => 'required',
            'address' => 'required',
        ]);

        $student = Student::findOrFail($id);

        if ($student) {
            $student->name = $request->name;
            $student->className = $request->className;
            $student->address = $request->address;
            $student->save();

            return response()->json('success', 200);
        }else{
            return response()->json('failes', 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, $id)
    {
        $student = Student::findOrFail($id);

        if ($student) {
            $student->delete();
            return response()->json('success', 200);
        }else{
            return response()->json('failed', 404);
        }

    }
}
