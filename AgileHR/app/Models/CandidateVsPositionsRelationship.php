<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateVsPositionsRelationship extends Model
{
    use HasFactory;

    protected $table='candidate_positions_relationship';
    protected $primaryKey = 'ID';    
}
