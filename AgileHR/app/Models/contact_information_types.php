<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact_information_types extends Model
{
    use HasFactory;

    protected $table='contact_information_types';
    protected $primaryKey = 'ID';
    protected $fillable = ['ContactType'];
}
