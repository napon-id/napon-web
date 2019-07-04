<?php

namespace App\Http\Controllers\Traits;

use GuzzleHttp\Client as Client;
/**
 * Midtrans implementation
 */
trait MidTrans
{
    // BNI Virtual Account

    /**
     * create midtrans transaction for product order
     * 
     * @param App\Order
     * 
     * @return array res
     */
    public function orderMidTrans(\App\Order $order)
    {
        $client = new Client();

        $res = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
            'auth' => [
                'SB-Mid-server-2qBPvk5TYHAsxZIBOM4qYPln',
                ''
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'payment_type' => 'bank_transfer',
                'transaction_details' => [
                    'gross_amount' => $order->product->tree_quantity * $order->product->tree->price,
                    'order_id' => $order->token
                ],
                'customer_details' => [
                    'email' => $order->user->email,
                    'phone' => $order->user->userInformation->phone
                ],
                'item_details' => [
                    [
                        'id' => $order->product->name,
                        'price' => $order->product->tree->price,
                        'quantity' => $order->product->tree_quantity,
                        'name' => $order->product->tree->name
                    ]
                ],
                'bank_transfer' => [
                    "bank" => "bni",
                    "va_number" => "00000"
                ]
            ]
        ]);

        return $res;
    }

    /**
     * create midtrans transaction for balance top-up
     * 
     * @param App\Topup
     * 
     * @return array res
     */
    public function topUpMidtrans(\App\Topup $topup)
    {
        $client = new Client();

        $res = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
            'auth' => [
                'SB-Mid-server-2qBPvk5TYHAsxZIBOM4qYPln',
                ''
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'payment_type' => 'bank_transfer',
                'transaction_details' => [
                    'gross_amount' => $topup->amount,
                    'order_id' => $topup->token
                ],
                'customer_details' => [
                    'email' => $topup->user->email,
                    'phone' => $topup->user->userInformation->phone
                ],
                'item_details' => [
                    [
                        'id' => 'Top-Up',
                        'price' => $topup->amount,
                        'quantity' => 1,
                        'name' => 'Top-Up'
                    ]
                ],
                'bank_transfer' => [
                    "bank" => "bni",
                    "va_number" => "00000"
                ]
            ]
        ]);

        return $res;
    }
}
