@component('mail::message')
<h2>
    Hai, {{ $order->user()->first()->email }}
</h2>
{{ $status[$order->status] }}

Detail tabungan {{ $order->product()->first()->name }} anda:

@component('mail::table')
| Informasi       | Keterangan                                                               |
|:--------------- |:-------------------------------------------------------------------------|
| Tanggal         | {{ $order->created_at->format('d-m-Y h:i:sa') }}                         |
| Pohon           | {{ $order->product()->first()->tree()->first()->name }}                  |
| Jumlah pohon    | {{ $order->product()->first()->tree_quantity }}                          |
| Durasi menabung | {{ $order->product()->first()->time }}                                   |
| Keuntungan      | {{ $order->product()->first()->percentage }}%                            |
| Status          | {{ $status[$order->status] }}                                            |
| Lokasi          | {{ $order->location()->first()->address ?? 'Lokasi belum ditentukan' }}  |
@if($order->status == 4 && $order->selling_price > 0)
|Harga jual       | {{ formatCurrency($order->selling_price) }}                              |
@endif
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
