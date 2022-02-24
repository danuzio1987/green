<?php

namespace App\Models\Vendas;

use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Produto;
use App\Models\Detalhes\Detalhamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_date',
        'cliente_id',
        'notes',
        'qtd_sale',
    ];

    //relacionamento polimórfico
    public function details()
    {
        return $this->morphMany(Detalhamento::class, 'detail');
    }

    public function produtos()
    {
       return $this->belongsToMany(Produto::class)->withPivot("qtd_sale", "armazem_id", "detail_type", "qtd_delivered", "date_retirada", "uniq_code");
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, "cliente_id", "id");
    }

    public function entregas()
    {
        return $this->hasMany(Delivery::class);
    }
}
