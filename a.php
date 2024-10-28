<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'UserID';

    protected $fillable = [
        'Username',
        'Password',
        'Role',
        'FirstName',
        'LastName',
        'Email',
        'IsTeacher',
        'IsActive'
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $casts = [
        'IsTeacher' => 'boolean',
        'IsActive' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    public function epRotations()
    {
        return $this->hasMany(EPRotation::class, 'UserID', 'UserID');
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function isAdmin()
    {
        return $this->Role === 'Admin';
    }

    public function isTeacher()
    {
        return $this->Role === 'Teacher';
    }

    public function isAttendanceTaker()
    {
        return $this->Role === 'AttendanceTaker';
    }
}
