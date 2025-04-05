<?php

namespace App\Http\Controllers;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;



class DepartmentController extends Controller
{
    public function showDepartments($collegeId)
    {
        $college = College::findOrFail($collegeId);
        $departments = Department::withTrashed()->where('CollegeID', $collegeId)->get();

        return view('departments_list', compact('departments', 'college'));
    }

    public function store(Request $request)
    {

//4
        Department::create([
            'DepartmentCode' => $request->code,
            'DepartmentName' => $request->name,
            'CollegeID' => $request->college_id,
            'IsActive' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Department added successfully!');
    }


    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
//5
        try {
            $department->update([
                'DepartmentCode' => $request->code,
                'DepartmentName' => $request->name,
                'IsActive' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Department updated successfully!');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // SQL Duplicate Entry Error
                return redirect()->back()->withErrors(['code' => 'The department code already exists']);
            }
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }


    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->back()->with('success', 'Department deleted successfully.');
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();

        return redirect()->back()->with('success', 'Department restored.');
    }

    public function forceDelete($id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->forceDelete();
        return redirect()->back()->with('success', 'Department permanently deleted.');
    }

}
