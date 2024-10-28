<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EPRotation extends Model
{
    protected $table = 'ep_rotation';
    protected $primaryKey = 'EP_RotationID';

    protected $fillable = [
        'EPID',
        'RotationID',
        'UserID',
        'IsActive'
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function ep()
    {
        return $this->belongsTo(EP::class, 'EPID', 'EPID');
    }

    public function rotation()
    {
        return $this->belongsTo(Rotation::class, 'RotationID', 'RotationID');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_ep_rotation', 'EP_RotationID', 'StudentID')
            ->withPivot('IsActive')
            ->withTimestamps();
    }
}
