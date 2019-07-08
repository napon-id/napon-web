@component('mail::message')
<h2>
    Hai, {{ $order->user()->first()->email }}
</h2>
Anda telah memesan tabungan {{ $order->product()->first()->name }}
<br>dengan detail sebagai berikut:

@component('mail::table')
| Informasi       | Keterangan                                                               |
|:--------------- |:-------------------------------------------------------------------------|
| Tanggal         | {{ $order->created_at->format('d-m-Y h:i:sa') }}                         |
| Pohon           | {{ $order->product()->first()->tree()->first()->name }}                  |
| Jumlah pohon    | {{ $order->product()->first()->tree_quantity }}                          |
| Harga per pohon | {{ formatCurrency($order->product()->first()->tree()->first()->price) }} |
| Durasi menabung | {{ $order->product()->first()->time }}                                   |
| Keuntungan      | {{ $order->product()->first()->percentage }}%                            |
| Status          | Menunggu deposit                                                         |
@endcomponent

<br>
Silakan melakukan deposit sebesar :
<br>{{ formatCurrency($order->buy_price) }}

ke salah satu rekening {{ config('app.name') }} berikut:
@component('mail::table')
| Bank        | Kode Bank | Nomor Rekening | Nama Rekening                 |
|:------      |:---------:|:---------------|:------------------------------|
@foreach(config('banks') as $id=>$name)
| {{ $name }} | {{ $id }} | {{ $name }}    | PT. Napon Investama Indonesia |
@endforeach
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
