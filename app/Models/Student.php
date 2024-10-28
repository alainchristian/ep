<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'StudentID';

    protected $fillable = [
        'UniqueID',
        'FirstName',
        'LastName',
        'FamilyID',
        'Gender',
        'IsActive'
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function family()
    {
        return $this->belongsTo(Family::class, 'FamilyID', 'FamilyID');
    }

    public function epRotations()
    {
        return $this->belongsToMany(EPRotation::class, 'student_ep_rotation', 'StudentID', 'EP_RotationID')
            ->withPivot('IsActive')
            ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasManyThrough(
            Attendance::class,
            StudentEPRotation::class,
            'StudentID',
            'Student_EP_RotationID',
            'StudentID',
            'Student_EP_RotationID'
        );
    }
}
