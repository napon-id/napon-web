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
        //get product
        $product = \App\Product::find($order->product_id);
        // get tree
        $tree = \App\Tree::find($product->tree_id);
        //get user
        $user = \App\User::find($order->user_id);

        $mail = new \App\Mail\OrderCreatedMail($order, $user);
        Mail::to($user->email)
            ->queue($mail);
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

            // TODO: Fix this ambiguities on setting up balance
            if ($column == 'selling_price') {
                if ($order->status == 4) {
                    $currentBalance = $user->balance->balance;
                    $oldValue = $order->getOriginal('selling_price');
                    $user->balance->update([
                        'balance' => $currentBalance + $newValue - $oldValue
                    ]);
                }
            }

            if ($column == 'status' && $order->selling_price > 0) {
                if ($newValue == 4) {
                    $addToBalance = $order->getOriginal('selling_price');
                    $currentBalance = $user->balance->balance;

                    $user->balance->update([
                        'balance' => $addToBalance + $currentBalance
                    ]);
                }

            }
        }
        \Log::info($columns);
    }
}
