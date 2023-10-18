<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'telefone', 'foto', 'sexo'];

    /* Retornar a URL da imagem */
    public function getUrlImagemAttribute()
    {
        return asset("storage/{$this->foto}");
    }
}
