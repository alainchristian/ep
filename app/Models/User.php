<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'UserID';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'Username',
        'Email',
        'Password',
        'FirstName',
        'LastName',
        'Role',
        'IsTeacher',
        'IsActive'
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $attributes = [
        'Role' => 'Teacher',     // Default role
        'IsTeacher' => 0,        // Default not a teacher
        'IsActive' => 1          // Default active
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

    public function hasPermission($permission)
    {
        switch ($permission) {
            case 'manage_students':
            case 'manage_eps':
            case 'manage_users':
                return $this->isAdmin();

            case 'take_attendance':
                return $this->isAdmin() || $this->isTeacher() || $this->isAttendanceTaker();

            case 'view_reports':
                return $this->isAdmin() || $this->isTeacher();

            case 'manage_own_eps':
                return $this->isTeacher();

            default:
                return false;
        }
    }
}
