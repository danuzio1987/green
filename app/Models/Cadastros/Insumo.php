<?php

namespace App\Models\Cadastros;

use App\Models\Detalhes\Detalhamento;
use App\Models\Pedidos\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insumo extends Model
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
        'armazem_id',
        'qtd_forecast',
        'qtd_real',
        'data_descarga_item_pedido'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withPivot(["percent"]);
    }

    public function armazens()
    {
        return $this->belongsToMany(Armazem::class)->withPivot(["volume", "lastro"])->withTimestamps();
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)->withPivot(["armazem_id", "qtd_forecast", "qtd_real", "data_descarga_item_pedido"])->withTimestamps();
    }

    public function details()
    {
        return $this->hasMany(Detalhamento::class, "insumo_id", "id");
    }


}
