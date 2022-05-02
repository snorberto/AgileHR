<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidates extends Model
{
    use HasFactory;

    protected $table='candidate_details';
    protected $primaryKey = 'ID';
    protected $fillable = ['Name'];
}
