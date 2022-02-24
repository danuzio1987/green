<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Pedidos\Pedido;

class PedidoEnviado extends Notification
{
    use Queueable;

    private $user;
    private $pedido;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Pedido $pedido)
    {
        $this->user = $user;
        $this->pedido = $pedido;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Novo pedido emitido")
                    ->line('Solicitação de Insumo')
                    ->action('Veja pedidos', url('/pedidos/pedidos'))
                    ->line('Um novo pedido foi emitido por' . $this->user->first_name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            $this->user->profile,
            'usuario' => $this->user->first_name . " " . $this->user->last_name,
            'mensagem' => " emitiu um novo Pedido"
        ];
    }
}
