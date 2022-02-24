<?php

namespace App\Models\Cadastros;

use App\Models\Vendas\Venda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'percent',
        'qtd_sale'
    ];

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class)->withPivot("percent");
    }

    public function vendas()
    {
        return $this->belongsToMany(Venda::class)->withPivot("qtd_sale", "armazem_id", "detail_type", "qtd_delivered", "date_retirada", "uniq_code");
    }


}
