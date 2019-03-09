<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('(Update) Pemesanan Produk Tabungan'))
            ->markdown('mails.order.updated')
            ->with([
                'order' => $this->order,
                'status' => config('orders'),
            ]);
    }
}
