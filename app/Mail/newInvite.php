<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newInvite extends Mailable
{
    use Queueable, SerializesModels;

    private $user_name;
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $email)
    {
        $this->user_name = $user_name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email, $this->user_name)->subject("🚨 Você recebeu um convite da Green")->from('danuzio.1987@gmail.com', "Green Combustíveis")->markdown('emails.invites', [
            "user_name" => $this->user_name,
            "email" => $this->email
        ]);
    }
}
