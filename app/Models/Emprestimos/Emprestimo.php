<?php

namespace App\Models\Emprestimos;

use App\Models\Detalhes\Detalhamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emprestimo extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner',
        'notes'
    ];

    //relacionamento polimórfico
    public function details()
    {
        return $this->morphOne(Detalhamento::class, 'detail');
    }

}
