<?php

namespace App\Models\Vendas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venda_id',
        'uniq_code',
        'entrega_produto_id',
        'entrega_armazem_id',
        'entrega_delivery_date',
        'entrega_qtd_delivered'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}
