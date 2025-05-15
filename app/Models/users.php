<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class users extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user'; 

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password', 
    ];

    public $timestamps = false;

    // Relasi: 1 user punya banyak todo
    public function todos()
    {
        return $this->hasMany(todoModel::class, 'id_user');
    }

    // Override untuk autentikasi default Laravel
    public function getAuthPassword()
    {
        return $this->pass;
    }
}
