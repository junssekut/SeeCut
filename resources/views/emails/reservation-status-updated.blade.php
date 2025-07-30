<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Reservasi SeeCut</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-finished {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .reservation-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-label {
            font-weight: bold;
            color: #495057;
        }

        .detail-value {
            color: #6c757d;
        }

        .message-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">✂️ SeeCut</div>
            <h2>Update Status Reservasi</h2>
        </div>

        <p>Halo <strong>{{ $reservation->name }}</strong>,</p>

        <p>Status reservasi Anda telah diperbarui!</p>

        <div class="status-badge status-{{ $status }}">
            {{ $statusMessage }}
        </div>

        <div class="reservation-details">
            <h3>Detail Reservasi</h3>
            <div class="detail-row">
                <span class="detail-label">ID Reservasi:</span>
                <span class="detail-value">IDX-{{ $reservation->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nama:</span>
                <span class="detail-value">{{ $reservation->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $reservation->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">No. Telepon:</span>
                <span class="detail-value">{{ $reservation->phone }}</span>
            </div>
            @if ($reservation->slot)
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span
                        class="detail-value">{{ \Carbon\Carbon::parse($reservation->slot->date)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Waktu:</span>
                    <span
                        class="detail-value">{{ \Carbon\Carbon::parse($reservation->slot->start_time)->format('H:i') }}
                        WIB</span>
                </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">{{ $statusMessage }}</span>
            </div>
        </div>

        @if ($status === 'pending')
            <div class="message-box">
                <h4>🎯 Giliran Anda Sekarang!</h4>
                <p>Reservasi Anda sedang dalam proses. Mohon bersiap dan datang sesuai jadwal yang telah ditentukan. Tim
                    kami akan segera melayani Anda!</p>
            </div>
        @elseif($status === 'confirmed')
            <div class="message-box">
                <h4>✅ Reservasi Dikonfirmasi!</h4>
                <p>Reservasi Anda telah dikonfirmasi. Silakan datang sesuai jadwal yang telah ditentukan.</p>
            </div>
        @elseif($status === 'finished')
            <div class="message-box">
                <h4>🎉 Layanan Selesai!</h4>
                <p>Terima kasih telah menggunakan layanan SeeCut! Kami harap Anda puas dengan hasil pelayanan kami.
                    Jangan lupa untuk memberikan ulasan!</p>
            </div>
        @elseif($status === 'cancelled')
            <div class="message-box">
                <h4>❌ Reservasi Dibatalkan</h4>
                <p>Maaf, reservasi Anda telah dibatalkan. Silakan hubungi kami jika ada pertanyaan atau buat reservasi
                    baru.</p>
            </div>
        @endif

        @if ($status !== 'cancelled')
            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/') }}" class="btn">Kunjungi SeeCut</a>
            </div>
        @endif

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari sistem SeeCut.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi customer service kami.</p>
            <p><strong>SeeCut</strong> - Platform Booking Barbershop Terpercaya</p>
        </div>
    </div>
</body>

</html>
