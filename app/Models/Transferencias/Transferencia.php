<?php

namespace App\Models\Transferencias;

use App\Models\Cadastros\Armazem;
use App\Models\Detalhes\Detalhamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transfer_date',
        'descarga_date',
        'delivery_status',
        'origem_id',
        'qtd_origem',
        'destino_id',
        'qtd_destino',
        'notes',
    ];

    //relacionamento polimórfico
    public function details()
    {
        return $this->morphMany(Detalhamento::class, 'detail');
    }


}
