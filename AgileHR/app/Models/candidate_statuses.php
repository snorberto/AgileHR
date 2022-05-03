<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidate_statuses extends Model
{
    use HasFactory;

    protected $table='candidate_status';
    protected $primaryKey = 'ID';
    protected $fillable = ['CandidateStatus'];
}
