<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body style="margin:0; padding:0; background:#e5e7eb; font-family:Arial, Helvetica, sans-serif;">
    <div
        style="max-width:600px; margin:40px auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.08);">
        <div style="background:#111827; padding:20px;">
            <h2 style="color:white; margin:0;">Undangan Wawancara</h2>
        </div>
        <div style="padding:20px; color:#374151; font-size:14px; line-height:1.6;">
            <p>Yth. <strong>{{ $data['namaMahasiswa'] }}</strong>,</p>
            <p>
                Kami mengundang Anda untuk mengikuti wawancara pada proses rekrutmen untuk posisi:
            </p>
            <p style="font-size:20px; font-weight:bold; color:#111827; margin-top:6px;">
                {{ $data['namaLowongan'] }}
            </p>
            <hr style="border:none; border-top:1px solid #e5e7eb; margin:24px 0;">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="padding:8px 0; width:150px">Tanggal</td>
                    <td>: {{ $data['tanggal'] }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0;">Waktu</td>
                    <td>: {{ $data['mulai'] }} - {{ $data['selesai'] }} WIB</td>
                </tr>
                @if ($data['lokasi'])
                    <tr>
                        <td style="padding:8px 0;">Lokasi</td>
                        <td>: {{ $data['lokasi'] }}</td>
                    </tr>
                @endif
                @if ($data['link'])
                    <tr>
                        <td style="padding:8px 0;">Link Meeting</td>
                        <td>:
                            <a href="{{ $data['link'] }}"
                                style="color:white; background:#111827; padding:6px 14px; border-radius:6px; text-decoration:none; font-weight:bold;">
                                Join Meeting
                            </a>
                        </td>
                    </tr>
                @endif
            </table>
            <br>
            <div style="background:#f3f4f6; padding:14px; border-radius:8px;">
                <div style="font-weight:600; margin-bottom:6px;">
                    Informasi Kontak Unit
                </div>

                <div>
                    {{ $data['namaUnit'] }}
                </div>

                <div>
                    Emai: {{ $data['emailUnit'] }}
                </div>

                <div>
                    Kontak : {{ $data['kontakUnit'] }}
                </div>

                <div style="margin-top:10px;">
                    Mohon hadir tepat waktu. Jika Anda berhalangan hadir, silakan menghubungi kontak unit di atas.
                </div>
            </div>
            <br>
            <p style="margin-bottom:0;">Terima kasih.</p>
            <p style="margin-top:4px;"><strong>Tim Rekrutmen</strong></p>
        </div>
        <div style="background:#f9fafb; padding:16px; text-align:center; font-size:12px; color:#6b7280;">
            Sistem Rekrutmen dan Penilaian Student Employee Universitas Surabaya
        </div>
    </div>
</body>

</html>
