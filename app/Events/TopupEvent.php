<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Topup;

class TopupEvent
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

    public function topupUpdating(Topup $topup)
    {
        $columns = $topup->getDirty();

        foreach ($columns as $column => $newValue) {
            if ($column == 'status') {
                $oldStatus = $topup->getOriginal('status');
                $newStatus = $newValue;

                if ($oldStatus == 1 && $newStatus == 2) {
                    $topup->user->balance->update([
                        'balance' => $topup->user->balance->balance + $topup->amount
                    ]);
                }

                if ($oldStatus == 2) {
                    $topup->user->balance->update([
                        'balance' => $topup->user->balance->balance - $topup->amount
                    ]);
                }
                
            }
        }
    }
}
