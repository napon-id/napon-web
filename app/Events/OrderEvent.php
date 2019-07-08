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
            if ($column == 'selling_price') {
                if ($order->status == 'done') {
                    \Log::info('triggering balance update');
                    \Log::info('new selling price ' . $newValue);
                    \Log::info('old selling price ' . $order->getOriginal('selling_price'));
                    $selling_price = $newValue - $order->getOriginal('selling_price');
                    \Log::info('difference in selling price ' . $selling_price);
                    $user->balance()->first()->update([
                        'balance' => $user->balance()->first()->balance + $selling_price,
                    ]);
                }
            }
        }
        \Log::info($columns);
    }
}
