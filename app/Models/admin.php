<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    public function getAuthPassword() {
        return $this->password;
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->pluck('name')->contains($permission);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'id', 'permission_id')->select('user_permission.id');
    }
}
