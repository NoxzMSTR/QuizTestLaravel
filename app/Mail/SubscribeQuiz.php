<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeQuiz extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $userData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$userData)
    {
        $this->user = $user;
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user ;
        $userData = $this->userData ;
        return $this->view('quiz.email.subscribe',compact('user','userData'));
    }
}
