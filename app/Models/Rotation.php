<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rotation extends Model
{
    protected $table = 'rotation';
    protected $primaryKey = 'RotationID';

    protected $fillable = [
        'StartDate',
        'EndDate',
        'Year',
        'RotationNumber',
        'IsActive'
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function epRotations()
    {
        return $this->hasMany(EPRotation::class, 'RotationID', 'RotationID');
    }
}
