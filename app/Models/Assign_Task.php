<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign_Task extends Model
{
    use HasFactory;
    protected $table = 'assigned_task';
    protected $filleble  = [
        'task_id',
        'user_id'
    ];
}
