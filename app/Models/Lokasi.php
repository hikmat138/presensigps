<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi_kantor';
    protected $fillable = ['lokasi_kantor', 'latitude', 'longitude', 'radius'];
    public $timestamps = false;
}
