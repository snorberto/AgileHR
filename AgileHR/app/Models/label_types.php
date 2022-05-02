<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class label_types extends Model
{
    use HasFactory;

    protected $table='label_types';
    protected $primaryKey = 'ID';
    protected $fillable = ['Label_value'];
}
