<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['valor', 'nome', 'descricao', 'cliente_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
