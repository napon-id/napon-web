@component('mail::message')
<h2>
    Hai, {{ $withdraw->user()->first()->email }}
</h2>
Anda telah mengajukan permintaan pencairan saldo dengan informasi sebagai berikut:

@component('mail::table')
| Informasi         | Keterangan                                          |
|:----------------- |:----------------------------------------------------|
| Tanggal           | {{ $withdraw->created_at->format('d-m-Y h:i:sa') }} |
| Bank Penerima     | {{ $withdraw->account()->first()->name }}           |
| Rekening penerima | {{ $withdraw->account()->first()->number }}         |
| Nama penerima     | {{ $withdraw->account()->first()->holder_name }}    |
| Jumlah            | {{ formatCurrency($withdraw->amount) }}             |
| Status            | {{ $withdraw->status }}                             |

@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
