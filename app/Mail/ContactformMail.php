<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactformMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        // dd($data);
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->data['name']);
        $senderName = $this->data['name'];
        $senderNohp = $this->data['nohp'];
        $senderMessage = strip_tags($this->data['message']);
        // dd($senderProduct);
        $data = [
            'senderName' => $senderName,
            'senderNohp' => $senderNohp,
            'senderMessage' => $senderMessage
        ];

        // return $this->from(config('mail.from.address'))
        //         ->subject('New Contact Form Submission')
        //         ->view('mails/webform')
        //         ->with($data);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Submission from TB Website | Contact Us')
            ->view('mails/contactform')
            ->with($data);
    }
}
