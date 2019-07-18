<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Order;
use Mail;
use App\Activity;

class OrderEvent
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

    public function orderCreated(Order $order)
    {
        //get user
        $user = \App\User::find($order->user_id);

        $mail = new \App\Mail\OrderCreatedMail($order, $user);
        Mail::to($user->email)
            ->queue($mail);

        // add activity log
        $activity = Activity::create([
            'activity_id' => $order->getKey(),
            'activity_type' => get_class($order),
            'content' => 'User ' . $order->user->email . ' memesan tabungan : ' . $order->product->name . 
                '. <a href="'.route('admin.user.order', ['user' => $order->user]).'">Klik untuk menampilkan tabungan</a>'
        ]);
    }

    public function orderUpdated(Order $order)
    {
        $user = $order->user()->first();

        $mail = new \App\Mail\OrderUpdatedMail($order, $user);
        Mail::to($user->email)
            ->queue($mail);
    }

    public function orderUpdating(Order $order)
    {
        // get product
        $product = $order->product()->first();
        // get user
        $user = $order->user()->first();

        $columns = $order->getDirty();
        foreach ($columns as $column => $newValue) {

            if ($column == 'selling_price') {
                if ($order->status == 4) {
                    $currentBalance = $user->balance->balance;
                    $oldValue = $order->getOriginal('selling_price');
                    $user->balance->update([
                        'balance' => $currentBalance + $newValue - $oldValue
                    ]);
                }
            }

            if ($column == 'status') {
                if ($order->getOriginal('status') == 4 && $newValue != 4) {
                    $user->balance->update([
                        'balance' => $user->balance->balance - $order->selling_price
                    ]);
                } 
            }
        }
        \Log::info($columns);
    }
}
