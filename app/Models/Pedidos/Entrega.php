<?php

namespace App\Models\Pedidos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrega extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
