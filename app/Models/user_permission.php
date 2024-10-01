<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_permission extends Model
{
    use HasFactory;
    protected $table = 'user_permission';
    protected $fillable = [
        'role_id',
        'permission_id',
        'list',
        'create',
        'update',
        'delete',
        'created_updated_by'
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
