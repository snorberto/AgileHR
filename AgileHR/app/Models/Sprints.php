<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprints extends Model
{
    use HasFactory;

    protected $table='sprints';
    protected $primaryKey = 'ID';
    protected $fillable = ['sprint_name', 'is_active'];
}
