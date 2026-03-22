<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body
    style="margin:0;font-family:Arial, Helvetica, sans-serif;background:#f3f4f6;height:100vh;
            display:flex;justify-content:center;align-items:center;">
    <div
        style="background:white;padding:40px;width:420px;border-radius:8px;box-shadow:0 10px 25px rgba(0,0,0,0.08);text-align:center;">
        @if ($aksi == 'terima')
            <div
                style="width:80px;
                height:80px;
                border-radius:50%;
                border:4px solid #22c55e;
                margin:0 auto 20px auto;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:40px;
                color:#22c55e;">
                ✓
            </div>
            <h2 style="margin-bottom:15px;color:#111827;"> Konfirmasi Berhasil</h2>

            <p style="color:#374151;font-size:15px; line-height:1.6;">
                Anda telah <strong>menyetujui</strong> jadwal wawancara yang diberikan.
            </p>

            <p style="color:#6b7280; font-size:14px;margin-top:10px;">Terima kasih atas konfirmasi Anda.</p>
        @elseif($aksi == 'tolak')
            <div
                style="width:80px;
                height:80px;
                border-radius:50%;
                border:4px solid #ef4444;
                margin:0 auto 20px auto;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:40px;
                color:#ef4444;">
                ✕
            </div>
            <h2 style="margin-bottom:15px; color:#111827;">Konfirmasi Berhasil </h2>
            <p style="color:#374151; font-size:15px;line-height:1.6;">Anda telah <strong>menolak</strong> jadwal
                wawancara yang diberikan.</p>
            <p style="color:#6b7280;font-size:14px;margin-top:10px;">Tim rekrutmen akan melakukan penjadwalan ulang.</p>
        @elseif($aksi == 'jadwal_batal')
            <div
                style="width:80px;height:80px;border-radius:50%;border:4px solid #f59e0b;
                margin:0 auto 20px auto;display:flex;align-items:center;justify-content:center;
                font-size:40px;color:#f59e0b;">
                !
            </div>

            <h2 style="margin-bottom:15px; color:#111827;">Jadwal Sudah Dibatalkan</h2>

            <p style="color:#374151; font-size:15px;line-height:1.6;">
                Jadwal wawancara ini sudah <strong>dibatalkan oleh tim rekrutmen</strong>.
                Konfirmasi tidak dapat dilakukan lagi.
            </p>

            <p style="color:#6b7280;font-size:14px;margin-top:10px;">
                Silakan menunggu informasi jadwal terbaru apabila dijadwalkan ulang.
            </p>
        @elseif($aksi == 'expired')
            <div
                style="width:80px;height:80px;border-radius:50%;border:4px solid #6b7280;
                margin:0 auto 20px auto;display:flex;align-items:center;justify-content:center;
                font-size:40px;color:#6b7280;">
                !
            </div>

            <h2 style="margin-bottom:15px; color:#111827;">Link Tidak Berlaku</h2>

            <p style="color:#374151; font-size:15px;line-height:1.6;">
                Link konfirmasi ini sudah <strong>tidak berlaku</strong> atau Anda sudah melakukan konfirmasi
                sebelumnya.
            </p>

            <p style="color:#6b7280;font-size:14px;margin-top:10px;">
                Jika ada perubahan jadwal, tim rekrutmen akan menghubungi Anda kembali.
            </p>
        @endif
    </div>
</body>
</html>
