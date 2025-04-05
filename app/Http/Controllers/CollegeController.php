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
        //2
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


}
