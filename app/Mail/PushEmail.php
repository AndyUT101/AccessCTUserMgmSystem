<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg_content)
    {
        $this->mail_content = str_replace(chr(10), "<br/>", $msg_content);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pushemail');
    }
}
