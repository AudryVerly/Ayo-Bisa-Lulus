<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body style="margin:0; padding:0; background:#e5e7eb; font-family:Arial, Helvetica, sans-serif;">
    <div
        style="max-width:600px; margin:40px auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 10px 28px rgba(0,0,0,0.08);">

        <div style="background:#dc3545; padding:20px;">
            <h2 style="margin:0; color:white;">Jadwal Wawancara Dibatalkan</h2>
        </div>

        <div style="padding:24px; color:#374151;">
            <p>Halo <strong>{{ $namaPenilai }}</strong>,</p>

            <p>
                Jadwal wawancara kandidat berikut telah <strong>dibatalkan</strong>.
            </p>

            <div style="background:#f3f4f6; padding:16px; border-radius:8px; margin:16px 0;">
                <p style="margin:4px 0;"><strong>Nama Kandidat</strong><br>{{ $data['namaMahasiswa'] }}</p>
                <p style="margin:4px 0;"><strong>Lowongan</strong><br>{{ $data['namaLowongan'] }}</p>
                <p style="margin:4px 0;"><strong>Tanggal</strong><br>{{ $data['tanggal'] }}</p>
                <p style="margin:4px 0;"><strong>Waktu</strong><br>{{ $data['mulai'] }} - {{ $data['selesai'] }}</p>
            </div>

            <p>
                Silakan menunggu informasi jadwal terbaru apabila wawancara dijadwalkan ulang.
            </p>

            <p style="margin-top:24px;">
                Terima kasih.
            </p>
        </div>
        <div style="background:#f9fafb; padding:10px; text-align:center; font-size:12px; color:#6b7280;">
            Sistem Rekrutmen dan Penilaian Student Employee Universitas Surabaya
        </div>
    </div>
</body>

</html>
