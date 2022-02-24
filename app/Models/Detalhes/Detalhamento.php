<?php

namespace App\Models\Detalhes;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detalhamento extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'insumo_id',
        'armazem_id',
        'product_id',
        'uniq_code',
        'date_report',
        'document',
        'type',
        'category',
        'moviment_type',
        'qtd'
    ];

    public function detail()
    {
        return $this->morphTo();
    }

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

}
