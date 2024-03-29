<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Withdraw;

class WithdrawCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $withdraw;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($withdraw)
    {
        $this->withdraw = $withdraw;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Pencairan Saldo Tabungan'))
            ->markdown('mails.withdraw.created')
            ->with('withdraw', $this->withdraw);
    }
}
