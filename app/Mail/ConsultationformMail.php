<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultationformMail extends Mailable
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
        $senderName = $this->data['name'];
        $senderNohp = $this->data['nohp'];
        $senderProduct = $this->data['produk'];

        $data = [
            'senderName' => $senderName,
            'senderNohp' => $senderNohp,
            'senderProduct' => $senderProduct
        ];

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Submission from TB Website | Consultation')
            ->view('mails/consultationform')
            ->with($data);
    }
}
