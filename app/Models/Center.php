<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $table = 'center';
    protected $primaryKey = 'CenterID';

    protected $fillable = [
        'CenterName',
        'IsActive'
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function eps()
    {
        return $this->hasMany(EP::class, 'CenterID', 'CenterID');
    }
}
