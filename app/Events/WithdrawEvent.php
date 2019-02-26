<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Mail\WithdrawCreatedMail;
use App\Mail\WithdrawUpdatedMail;
use App\Withdraw;
use Mail;

class WithdrawEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function withdrawCreated(Withdraw $withdraw)
    {
        $withdraw->user()->first()->balance()->first()->update([
            'balance' => $withdraw->user()->first()->balance()->first()->balance - $withdraw->amount,
        ]);

        $mail = new WithdrawCreatedMail($withdraw);
        Mail::to($withdraw->user()->first()->email)
            ->queue($mail);
    }

    public function withdrawUpdated(Withdraw $withdraw)
    {
        $mail = new WithdrawUpdatedMail($withdraw);
        Mail::to($withdraw->user()->first()->email)
            ->queue($mail);

        if ($withdraw->status == 'rejected') {
            $withdraw->user()->first()->balance()->first()->update([
                'balance' => $withdraw->user()->first()->balance()->first()->balance + $withdraw->amount,
            ]);
        }
    }
}
