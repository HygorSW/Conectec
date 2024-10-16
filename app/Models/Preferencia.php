<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferencia extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'preferencia_id','nomePreferencia']; // Atualize para 'preferencia_id'




public function users()
{
    return $this->belongsToMany(User::class, 'preferencia_user');
}

public function preferenciaslista()
{
    return $this->belongsToMany(User::class, 'preferencia_lista');
}
}