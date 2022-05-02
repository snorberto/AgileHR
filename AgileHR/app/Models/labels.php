<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labels extends Model
{
    use HasFactory;
    
    protected $table='labels';
    protected $primaryKey = 'ID';
    protected $fillable = ['candidate_id', 'label_type_id'];
}
