<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class position_status extends Model
{
    use HasFactory;

    protected $table='position_statuses';
    protected $primaryKey = 'ID';
    protected $fillable = ['PositionStatus'];
}
