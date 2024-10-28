<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEPRotation extends Model
{
    protected $table = 'student_ep_rotation';
    protected $primaryKey = 'Student_EP_RotationID';

    protected $fillable = [
        'StudentID',
        'EP_RotationID',
        'IsActive'
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'StudentID', 'StudentID');
    }

    public function epRotation()
    {
        return $this->belongsTo(EPRotation::class, 'EP_RotationID', 'EP_RotationID');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'Student_EP_RotationID', 'Student_EP_RotationID');
    }
}
