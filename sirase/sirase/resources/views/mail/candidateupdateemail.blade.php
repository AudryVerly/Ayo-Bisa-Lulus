<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="margin:0;background:#f4f4f5;font-family:Arial,Helvetica,sans-serif">
    <div
        style="max-width:600px;margin:40px auto;background:white;border-radius:10px;border:1px solid #e5e7eb;overflow:hidden">

        <div style="background:#7f1d1d;padding:18px">
            <h2 style="color:white;margin:0;font-weight:600">
                Jadwal Wawancara Dibatalkan
            </h2>
        </div>

        <div style="padding:24px;color:#374151;font-size:14px;line-height:1.6">

            <p>Yth. <strong>{{ $jadwal['namaMahasiswa'] }}</strong>,</p>

            <p>
                Kami informasikan bahwa jadwal wawancara Anda untuk posisi berikut
                tidak dapat dilaksanakan.
            </p>

            <p style="font-size:18px;font-weight:bold;color:#111827;margin-top:6px">
                {{ $jadwal['namaLowongan'] }}
            </p>

            <hr style="border:none;border-top:1px solid #e5e7eb;margin:18px 0">

            <table style="width:100%">

                <tr>
                    <td style="padding:6px 0;width:120px">Tanggal</td>
                    <td>: {{ $jadwal['tanggal'] }}</td>
                </tr>

                <tr>
                    <td style="padding:6px 0">Waktu</td>
                    <td>: {{ $jadwal['mulai']}} - {{ $jadwal['selesai'] }} WIB</td>
                </tr>

            </table>

            <div style="background:#fef2f2;padding:14px;border-radius:6px;margin-top:20px">
                Tim rekrutmen akan melakukan penjadwalan ulang dan menghubungi Anda kembali.
            </div>

            <p style="margin-top:20px">
                Terima kasih,<br>
                <strong>Tim Rekrutmen</strong>
            </p>

        </div>

        <div style="background:#f3f4f6;text-align:center;padding:12px;font-size:12px;color:#6b7280">
            Sistem Rekrutmen Student Employee Universitas Surabaya
        </div>

    </div>
</body>

</html>
