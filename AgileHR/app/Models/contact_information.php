<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact_information extends Model
{
    use HasFactory;
    protected $table='contact_information';
    protected $primaryKey = 'ID';
    protected $fillable = ['candidate_id','contact_type_id', 'ContactInfo_value'];
}
