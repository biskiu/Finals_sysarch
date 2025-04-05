<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'DepartmentID';
    protected $fillable = ['CollegeID', 'DepartmentName', 'DepartmentCode', 'IsActive'];
    protected $dates = ['deleted_at']; // Enables soft delete support
    

    public function college()
    {
        return $this->belongsTo(College::class, 'CollegeID', 'CollegeID');
    }
}

