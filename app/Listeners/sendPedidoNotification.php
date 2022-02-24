<?php

namespace App\Listeners;

use App\Models\Pedidos\Pedido;
use App\Models\User;
use App\Notifications\PedidoEnviado;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class sendPedidoNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = User::find($event->user->id);
        $pedido = Pedido::find($event->pedido->id);
        $user->notify(new PedidoEnviado($user, $pedido));
    }
}
