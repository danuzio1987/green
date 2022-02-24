<?php

namespace App\Models\Pedidos;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Usina;
use App\Models\Detalhes\Detalhamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Pedido extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'solicitation_date',
        'usina_id',
        'fornecedor_id',
        'tipo_entrega',
        'order_status',
        'delivery_date',
        'window_start',
        'window_finish',
        'document',
        'notes',
        'armazem_id',
        'qtd_forecast',
        'qtd_real',
        'data_descarga_item_pedido'
    ];


    public function usina()
    {
        return $this->belongsTo(Usina::class);
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class)->withPivot(["armazem_id", "qtd_forecast", "qtd_real", "data_descarga_item_pedido"])->withTimestamps();
    }

    public function armazem()
    {
        return $this->belongsTo(Armazem::class);
    }

    //relacionamento polimórfico
    public function details()
    {
        return $this->morphMany(Detalhamento::class, 'detail');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

}
