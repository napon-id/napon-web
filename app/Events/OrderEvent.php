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
use App\OrderUpdate;
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
            'user_id' => $order->user_id,
            'activity' => 'Memesan produk tabungan : '. $product->name . ' ('. $product->tree_quantity .' pohon) dengan nomor transaksi : ' . $order->token,
        ]);

        // notify user via email
    }

    public function orderUpdated(Order $order)
    {
        // get product
        $product = $order->product()->first();

        if ($order->status == 'paid') {
            OrderUpdate::create([
                'order_id' => $order->id,
                'title' => 'Deposit berhasil',
                'description' => 'Selamat. Produk tabungan '.$product->name.' anda telah mulai berjalan. Saat ini kami sedang menanam pohon Anda.'
            ]);
        } else if ($order->status == 'investing') {
            OrderUpdate::create([
                'order_id' => $order->id,
                'title' => 'Proses penanaman telah selesai dilakukan',
                'description' => 'Pohon anda telah selesai kami tanam. Kami akan memberikan laporan rutin pohon Anda disini.'
            ]);
        } else if ($order->status == 'done') {
            OrderUpdate::create([
                'order_id' => $order->id,
                'title' => 'Pohon telah siap dijual',
                'description' => 'Selamat. Pohon Anda telah memasuki masa panen. Tahap selanjutnya adalah tahap penjualan pohon. Kami akan tetap memberikan perkembangan informasi disini.'
            ]);
        } else {
            \Log::info('order update for ' . $order->id . ' fired');
        }
    }
}
