<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_permission extends Model
{
    use HasFactory;

    protected $table='role_permissions';
    protected $primaryKey = 'ID';
    protected $fillable = ['RoleDescription'];
}
