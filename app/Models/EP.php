<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EP extends Model
{
    protected $table = 'ep';
    protected $primaryKey = 'EPID';

    protected $fillable = [
        'EPName',
        'CenterID',
        'IsActive'
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function center()
    {
        return $this->belongsTo(Center::class, 'CenterID', 'CenterID');
    }

    public function rotations()
    {
        return $this->hasMany(EPRotation::class, 'EPID', 'EPID');
    }
}
