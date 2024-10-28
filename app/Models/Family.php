<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'family';
    protected $primaryKey = 'FamilyID';

    protected $fillable = [
        'FamilyName',
        'FamilyMana',
        'IsActive'
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'FamilyID', 'FamilyID');
    }
}
