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
use App\Log;

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

        // create transaction for faster query purpose
        $transaction = new \App\Transaction;
        $transaction->order_id = $order->id;
        $transaction->total = $tree->price * $product->tree_quantity;
        $transaction->save();

        // write to log
        $log = Log::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Memesan produk tabungan dengan ID : ' . $product->id,
        ]);

        // notify user via email
    }
}
