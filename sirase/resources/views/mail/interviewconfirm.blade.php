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
        @else
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
        @endif
    </div>
</body>

</html>
