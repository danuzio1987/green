<?php

namespace App\Models;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Tancagem;
use App\Models\Cadastros\Usina;
use App\Models\Perfil\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function usinas()
    {
        return $this->hasMany(Usina::class);
    }

    public function armazens()
    {
        return $this->hasMany(Armazem::class);
    }

    public function fornecedores()
    {
        return $this->hasMany(Fornecedor::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
    
}
