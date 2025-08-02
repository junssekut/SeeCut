<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Reservasi SeeCut</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: #1f2937;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            position: relative;
        }

        .email-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        .header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 40px 40px 30px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 400;
            color: #e2e8f0;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .content-area {
            padding: 40px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 24px;
            color: #374151;
        }

        .greeting strong {
            color: #1f2937;
            font-weight: 600;
        }

        .status-update {
            text-align: center;
            margin: 32px 0;
            padding: 24px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            margin: 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .status-confirmed {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #047857;
            border: 1px solid #10b981;
        }

        .status-finished {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1d4ed8;
            border: 1px solid #3b82f6;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            color: #dc2626;
            border: 1px solid #ef4444;
        }

        .reservation-details {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            margin: 32px 0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .details-header {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            color: white;
            padding: 20px 24px;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .details-body {
            padding: 24px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }

        .detail-row:hover {
            background-color: #f9fafb;
            margin: 0 -24px 16px;
            padding: 16px 24px;
            border-radius: 8px;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            color: #6b7280;
            font-weight: 500;
            text-align: right;
            font-size: 14px;
        }

        .detail-value.highlight {
            color: #1f2937;
            font-weight: 600;
        }

        .message-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #3b82f6;
            border-left: 6px solid #3b82f6;
            padding: 24px;
            margin: 32px 0;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .message-box::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(59, 130, 246, 0.05);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .message-box h4 {
            margin: 0 0 12px 0;
            color: #1e40af;
            font-weight: 600;
            font-size: 16px;
            position: relative;
            z-index: 1;
        }

        .message-box p {
            margin: 0;
            color: #1e40af;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .message-box.pending {
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
            border-color: #f59e0b;
        }

        .message-box.pending h4,
        .message-box.pending p {
            color: #92400e;
        }

        .message-box.confirmed {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #10b981;
        }

        .message-box.confirmed h4,
        .message-box.confirmed p {
            color: #047857;
        }

        .message-box.finished {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-color: #0ea5e9;
        }

        .message-box.finished h4,
        .message-box.finished p {
            color: #0c4a6e;
        }

        .message-box.cancelled {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            border-color: #ef4444;
        }

        .message-box.cancelled h4,
        .message-box.cancelled p {
            color: #dc2626;
        }

        .footer {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            text-align: center;
            margin-top: 0;
            padding: 40px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }

        .footer p {
            margin: 8px 0;
            line-height: 1.6;
        }

        .footer strong {
            color: #374151;
            font-weight: 600;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px 32px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            margin: 24px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.3);
            border: 2px solid transparent;
        }

        .btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px 0 rgba(59, 130, 246, 0.4);
            color: white;
            text-decoration: none;
        }

        .cta-section {
            text-align: center;
            margin: 40px 0;
            padding: 32px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 32px 0;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            body {
                padding: 10px;
            }

            .email-container {
                border-radius: 12px;
            }

            .header,
            .content-area,
            .footer {
                padding: 24px 20px;
            }

            .details-body {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .detail-value {
                text-align: left;
                font-weight: 600;
                color: #1f2937;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">
                ✂️ SeeCut
            </div>
            <h2>Update Status Reservasi</h2>
        </div>

        <div class="content-area">
            <p class="greeting">Halo <strong>{{ $reservation->name }}</strong>,</p>

            <div class="status-update">
                <p style="margin: 0 0 16px 0; color: #6b7280; font-weight: 500;">Status reservasi Anda telah diperbarui!
                </p>
                <div class="status-badge status-{{ $status }}">
                    @if ($status === 'pending')
                        ⏳ {{ $statusMessage }}
                    @elseif($status === 'confirmed')
                        ✅ {{ $statusMessage }}
                    @elseif($status === 'finished')
                        🎉 {{ $statusMessage }}
                    @else
                        ❌ {{ $statusMessage }}
                    @endif
                </div>
            </div>

            <div class="reservation-details">
                <div class="details-header">
                    📋 Detail Reservasi
                </div>
                <div class="details-body">
                    <div class="detail-row">
                        <span class="detail-label">🆔 ID Reservasi:</span>
                        <span class="detail-value highlight">IDX-{{ $reservation->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">👤 Nama:</span>
                        <span class="detail-value">{{ $reservation->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">📧 Email:</span>
                        <span class="detail-value">{{ $reservation->email }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">📱 No. Telepon:</span>
                        <span class="detail-value">{{ $reservation->phone }}</span>
                    </div>
                    @if ($reservation->slot)
                        <div class="detail-row">
                            <span class="detail-label">📅 Tanggal:</span>
                            <span
                                class="detail-value highlight">{{ \Carbon\Carbon::parse($reservation->slot->date)->format('d M Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">🕐 Waktu:</span>
                            <span
                                class="detail-value highlight">{{ \Carbon\Carbon::parse($reservation->slot->start_time)->format('H:i') }}
                                WIB</span>
                        </div>
                    @endif
                    <div class="detail-row">
                        <span class="detail-label">📊 Status:</span>
                        <span class="detail-value highlight">{{ $statusMessage }}</span>
                    </div>
                </div>
            </div>

            @if ($status === 'pending')
                <div class="message-box pending">
                    <h4>🎯 Giliran Anda Sekarang!</h4>
                    <p>Reservasi Anda sedang dalam proses. Mohon bersiap dan datang sesuai jadwal yang telah ditentukan.
                        Tim kami akan segera melayani Anda!</p>
                </div>
            @elseif($status === 'confirmed')
                <div class="message-box confirmed">
                    <h4>✅ Reservasi Dikonfirmasi!</h4>
                    <p>Reservasi Anda telah dikonfirmasi. Silakan datang sesuai jadwal yang telah ditentukan.</p>
                </div>
            @elseif($status === 'finished')
                <div class="message-box finished">
                    <h4>🎉 Layanan Selesai!</h4>
                    <p>Terima kasih telah menggunakan layanan SeeCut! Kami harap Anda puas dengan hasil pelayanan kami.
                        Jangan lupa untuk memberikan ulasan!</p>
                </div>
            @elseif($status === 'cancelled')
                <div class="message-box cancelled">
                    <h4>❌ Reservasi Dibatalkan</h4>
                    <p>Maaf, reservasi Anda telah dibatalkan. Silakan hubungi kami jika ada pertanyaan atau buat
                        reservasi baru.</p>
                </div>
            @endif

            @if ($status !== 'cancelled')
                <div class="cta-section">
                    <a href="{{ url('/') }}" class="btn">
                        🏠 Kunjungi SeeCut
                    </a>
                </div>
            @endif

            <div class="divider"></div>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari sistem SeeCut.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi customer service kami.</p>
            <p><strong>SeeCut</strong> - Platform Booking Barbershop Terpercaya</p>
        </div>
    </div>
</body>

</html>
