<?php
namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CollegeController extends Controller
{

    public function showColleges()
    {
        $colleges = College::withTrashed()->get(); // Fetch all, including soft-deleted
        return view('colleges_list', compact('colleges'));
    }



    public function store(Request $request)
    {
        //1
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);
             // Convert input to lowercase for case-insensitive checking
             $codeLower = strtolower($request->code);
             $nameLower = strtolower($request->name);

             // Check if the code already exists (case insensitive)
             $existingCollegeByCode = College::whereRaw('LOWER(CollegeCode) = ?', [$codeLower])->withTrashed()->first();

             // Check if the name already exists (case insensitive)
             $existingCollegeByName = College::whereRaw('LOWER(CollegeName) = ?', [$nameLower])->withTrashed()->first();

             // If both code and name match deleted records
             if ($existingCollegeByCode && $existingCollegeByCode->trashed() && $existingCollegeByName && $existingCollegeByName->trashed()) {
                 return back()->with([
                     'restore_id' => $existingCollegeByCode->CollegeID,
                     'message' => 'A college with this code and name was deleted. Would you like to restore it?',
                 ]);
             }
             // If only the code matches a deleted record
             elseif ($existingCollegeByCode && $existingCollegeByCode->trashed()) {
                 return back()->with([
                     'restore_id' => $existingCollegeByCode->CollegeID,
                     'message' => 'A college with this code was deleted. Would you like to restore it?',
                 ]);
             }
             // If only the name matches a deleted record
             elseif ($existingCollegeByName && $existingCollegeByName->trashed()) {
                 return back()->with([
                     'restore_id' => $existingCollegeByName->CollegeID,
                     'message' => 'A college with this name was deleted. Would you like to restore it?',
                 ]);
             }
             // If code or name exists (not deleted)
             elseif ($existingCollegeByCode || $existingCollegeByName) {
                 $errors = [];
                 if ($existingCollegeByCode) {
                     $errors['code'] = 'The college code already exists.';
                 }
                 if ($existingCollegeByName) {
                     $errors['name'] = 'The college name already exists.';
                 }
                 return back()->withErrors($errors)->withInput();
             }

        College::create([
            'CollegeCode' => $request->code,
            'CollegeName' => $request->name,
            'IsActive' => $request->status,
        ]);

        return redirect()->back()->with('success', 'College added successfully!');
    }


    public function update(Request $request, $id)
    {
//3
$request->validate([
    'code' => 'required|unique:colleges,CollegeCode,' . $id . ',CollegeID',
    'name' => 'required|unique:colleges,CollegeName,' . $id . ',CollegeID',
    'status' => 'required|boolean'
]);

        $college = College::findOrFail($id);
        $college->update([
            'CollegeCode' => $request->code,
            'CollegeName' => $request->name,
            'IsActive' => $request->status
        ]);

        return redirect()->back()->with('success', 'College updated successfully!');
    }


    public function destroy($id)
    {
        $college = College::findOrFail($id);
        $college->delete(); // Soft delete (sets 'deleted_at' instead of hard delete)

        return redirect()->back()->with('success', 'College soft deleted successfully!');
    }

    public function restore($id)
    {
        $college = College::withTrashed()->findOrFail($id);
        $college->restore(); // Restores the soft-deleted record

        return redirect()->back()->with('success', 'College restored successfully!');
    }

    public function permanentDelete($id)
    {
        $college = College::withTrashed()->find($id);

        if (!$college) {
            return redirect()->back()->with('error', 'College not found.');
        }

        $college->forceDelete(); // Permanently remove from database

        return redirect()->back()->with('success', 'College permanently deleted.');
    }


    public function index(Request $request)
    {
        $query = College::query();

        if ($request->has('search')) {
            $query->where('CollegeName', 'like', '%' . $request->search . '%');
        }

        $colleges = $query->get();
        return view('colleges.index', compact('colleges'));
    }




}
