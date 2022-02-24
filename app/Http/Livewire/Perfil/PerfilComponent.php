<?php

namespace App\Http\Livewire\Perfil;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PerfilComponent extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'refresh-me' => '$refresh',
    ];

    public $first_name;
    public $last_name;
    public $email;
    public $avatar;
    public $email_verified_at;
    public $function;

    public $photo;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->avatar = $user->profile->avatar;
        $this->email_verified_at = $user->email_verified_at;
        $this->function = $user->profile->function;
    }

    public function updateProfile()
    {
        //'photo' => 'image|max:1024', // 1MB Max
        $customMessages = [
            'first_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'last_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
        ];

        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ], $customMessages);

        $user = User::findOrFail(Auth::user()->id);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->update();
        $user->profile->update([
            "function" => $this->function
        ]);

        if ($this->photo)
        {
            $user->profile->update([
                "avatar" => $this->photo->store("/", "avatars")
            ]);
        }
        
        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("sucesso-edita-usuario");
        $this->start();

        //$this->redirect(route('perfil.index'));

    }


    public function render()
    {
        return view('livewire.perfil.perfil-component');
    }
}
