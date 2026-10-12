<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - Home Improvement</title>

    {{-- Midtrans Snap.js --}}
    <script
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .detail {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            color: #6b7280;
        }

        .value {
            font-weight: 600;
            text-align: right;
        }

        .total {
            font-size: 20px;
            color: #111827;
        }

        .button {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            background: #111827;
            color: white;
            transition: 0.2s;
        }

        .button:hover {
            opacity: 0.9;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #6b7280;
            text-decoration: none;
        }

        .back:hover {
            color: #111827;
        }

        .info {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #fff7ed;
            color: #9a3412;
            font-size: 14px;
            line-height: 1.5;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <div class="title">
            Pembayaran Pesanan
        </div>

        <div class="subtitle">
            Silakan lanjutkan pembayaran melalui Midtrans.
        </div>

        <div class="detail">

            <div class="row">
                <span class="label">Nomor Pesanan</span>

                <span class="value">
                    #{{ $order->id_order }}
                </span>
            </div>

            <div class="row">
                <span class="label">Layanan</span>

                <span class="value">
                    {{ $order->subCategory->nama_sub_kategori ?? 'Layanan Perbaikan Rumah' }}
                </span>
            </div>

            <div class="row">
                <span class="label">Jumlah Unit</span>

                <span class="value">
                    {{ $order->jumlah_unit }}
                </span>
            </div>


            <div class="row">
                <span class="label total">
                    Total Pembayaran
                </span>

                <span class="value total">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </span>
            </div>

        </div>

        <button
            id="pay-button"
            class="button"
            type="button"
        >
            Bayar Sekarang
        </button>

        <a
            href="{{ route('dashboard.riwayat-order') }}"
            class="back"
        >
            Kembali ke Riwayat Pesanan
        </a>

        <div class="info">
            <strong>Mode Pengujian:</strong><br>
            Pembayaran ini menggunakan Midtrans Sandbox untuk kebutuhan pengujian sistem Tugas Akhir.
            Tidak menggunakan transaksi uang sungguhan.
        </div>

    </div>

</div>

<script>
    const payButton = document.getElementById('pay-button');

    payButton.addEventListener('click', function () {

        const snapToken = @json($snapToken);

        if (!snapToken) {
            alert('Token pembayaran tidak ditemukan.');
            return;
        }

        payButton.disabled = true;
        payButton.innerText = 'Membuka pembayaran...';

        window.snap.pay(snapToken, {

            onSuccess: function (result) {
                console.log('Pembayaran berhasil:', result);
                payButton.disabled = true;
                payButton.innerText = 'Konfirmasi pembayaran...';

                fetch("{{ route('dashboard.pembayaran-midtrans.success', $order->id_order) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        transaction_id: result.transaction_id || '',
                        payment_type: result.payment_type || 'online',
                        order_id: result.order_id || '',
                        raw_result: result
                    })
                })
                .then(function() {
                    alert('Pembayaran berhasil. Terima kasih!');
                    window.location.href = "{{ route('dashboard.riwayat-order') }}";
                })
                .catch(function(err) {
                    console.error('Error konfirmasi:', err);
                    alert('Pembayaran berhasil. Terima kasih!');
                    window.location.href = "{{ route('dashboard.riwayat-order') }}";
                });
            },

            onPending: function (result) {

                console.log('Pembayaran pending:', result);

                alert(
                    'Pembayaran masih menunggu penyelesaian.'
                );

                window.location.href =
                    "{{ route('dashboard.riwayat-order') }}";
            },

            onError: function (result) {

                console.error(
                    'Pembayaran gagal:',
                    result
                );

                alert(
                    'Pembayaran gagal. Silakan coba lagi.'
                );

                payButton.disabled = false;
                payButton.innerText = 'Bayar Sekarang';
            },

            onClose: function () {

                console.log(
                    'Halaman pembayaran ditutup.'
                );

                payButton.disabled = false;
                payButton.innerText = 'Bayar Sekarang';
            }

        });
    });
</script>

</body>
</html>