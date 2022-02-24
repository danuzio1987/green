<?php

namespace App\Models\Historico;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use App\Models\Pedidos\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function insumos()
    {
        return $this->hasMany(Insumo::class, "id", "insumo_id");
    }

    public function armazem()
    {
        return $this->belongsTo(Armazem::class, "armazem_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, "pedido_id", "id");
    }

    /**
* SITUAÇÕES QUE GERAM MOVIMENTO

*solicitação de pedido (previsto)
*confirmação de pedido (real)
*venda (real - percentual do produto no insumo)
*transferência (real)
*ajuste de estoque (real)
*Empréstimo Devolução (real)

     */

}
