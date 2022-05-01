<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;

    protected $table='positions';
    protected $primaryKey = 'ID';
    protected $fillable = ['opener_id', 'Description', 'Title'];
}
