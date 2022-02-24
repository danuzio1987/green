<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class inviteNewUser extends Mailable
{
    use Queueable, SerializesModels;

    private $url;
    private $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, User $user)
    {
        $this->url = $url;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('danuzio.1987@gmail.com')
                ->to($this->user->email, $this->user->first_name)
                ->subject("🥳 A GREEN tem um convite para você!")
                ->markdown('mail.invite.user', [
                    "url" => $this->url,
                    "user" => $this->user
                ]);
    }
}
