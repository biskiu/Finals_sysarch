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
$request->validate([
    'code' => [
        'required',
        Rule::unique('departments', 'DepartmentCode')->where(function ($query) use ($request) {
            return $query->where('CollegeID', $request->college_id);
        }),
    ],
    'name' => [
        'required',
        Rule::unique('departments', 'DepartmentName')->where(function ($query) use ($request) {
            return $query->where('CollegeID', $request->college_id);
        }),
    ],
    'college_id' => 'required|exists:colleges,CollegeID',
]);

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
$request->validate([
    'name' => [
        'required',
        Rule::unique('departments', 'DepartmentName')
            ->where(fn($query) => $query->where('CollegeID', $department->CollegeID))
            ->ignore($department->DepartmentID, 'DepartmentID'),
    ],
    'code' => [
        'required',
        Rule::unique('departments', 'DepartmentCode')
            ->where(fn($query) => $query->where('CollegeID', $department->CollegeID)) // Enforces uniqueness within the same college
            ->ignore($department->DepartmentID, 'DepartmentID'),
    ],
    'status' => 'required|boolean',
]);

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
