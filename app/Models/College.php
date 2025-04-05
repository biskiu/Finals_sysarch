<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class College extends Model
{
    use HasFactory, SoftDeletes; // Enable soft deletes

    protected $primaryKey = 'CollegeID';
    protected $fillable = ['CollegeName', 'CollegeCode', 'IsActive'];
    protected $dates = ['deleted_at']; // Track deletion date

    public function departments()
    {
        return $this->hasMany(Department::class, 'CollegeID', 'CollegeID');
    }
}

