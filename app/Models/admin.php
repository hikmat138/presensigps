<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    // Jika tetap ingin pakai email sebagai primary key
    protected $primaryKey = 'id'; // sebaiknya id auto-increment
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'name',   // gunakan 'name' supaya konsisten
        'email',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // otomatis hash
    ];
}
