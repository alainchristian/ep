<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'AttendanceID';

    protected $fillable = [
        'Student_EP_RotationID',
        'AttendanceDate',
        'Status'
    ];

    protected $casts = [
        'AttendanceDate' => 'date',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function studentEPRotation()
    {
        return $this->belongsTo(StudentEPRotation::class, 'Student_EP_RotationID', 'Student_EP_RotationID');
    }
}
