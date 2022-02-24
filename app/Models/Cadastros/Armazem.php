<?php

namespace App\Models\Cadastros;

use App\Models\Detalhes\Detalhamento;
use App\Models\Pedidos\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Armazem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class)->withPivot(["volume", "lastro"])->withTimestamps();
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    //relacionamento polimórfico
    public function details()
    {
        return $this->hasMany(Detalhamento::class, "armazem_id", "id");
    }

}
