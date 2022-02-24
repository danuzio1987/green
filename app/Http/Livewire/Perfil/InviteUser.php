<?php

namespace App\Http\Livewire\Perfil;

use App\Jobs\SendInviteUser;
use App\Mail\inviteNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Notifications\InviteUserNotification;

class InviteUser extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $role_id;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        $this->first_name = "";
        $this->last_name = "";
        $this->email = "";
        $this->role_id = "";
    }

    public function sendInvite()
    {
        $customMessages = [
            'first_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'last_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'email.required'  => '✋ Putz...como vai convidar sem e-mail?',
            'email.unique'  => 'Este e-mail já foi cadastrado antes.',
            'role_id.required'  => '✋ Campo obrigatório!!!',
        ];

        $this->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'role_id' => 'required'
        ], $customMessages);

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->password = "secret";
        $user->email_verified_at = date("Y-m-d H:i:s", strtotime(now()));
        $user->save();

        $user->profile()->create([
            "avatar" => "default.jpg",
            "function" => "Sem Função"
        ]);

        $role = Role::findOrFail($this->role_id);
        $user->assignRole($role);

        $url =URL::signedRoute('invitation', $user);
        
        $user->notify(new InviteUserNotification($url, $user));
        
/*
        SendInviteUser::dispatch($url, $user)->delay(now()->addSeconds('10'));
*/

        $this->dispatchBrowserEvent("sucesso-econvite");
        
        $this->start();


    }

    public function canceInvite()
    {
        $this->start();
    }


    public function render()
    {
        return view('livewire.perfil.invite-user', [
            "roles" => Role::all()
        ]);
    }
}
