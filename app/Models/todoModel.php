<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todoModel extends Model
{
    use HasFactory;

    protected $table = 'tb_todo';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'date',
        'id_user',
    ];

    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(users::class, 'id_user');
    }
}
