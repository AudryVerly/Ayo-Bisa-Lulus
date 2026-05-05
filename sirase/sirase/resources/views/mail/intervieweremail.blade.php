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
            <h2 style="color:white; margin:0;">Penugasan Pewawancara Student Employee</h2>
        </div>

        <div style="padding:20px; color:#374151; font-size:14px; line-height:1.6;">
            <p>Yth. <strong>{{ $namaPenilai }}</strong>,</p>
            <p>Anda dijadwalkan menjadi pewawancara dan penilai untuk kandidat berikut:</p>

            <div style="background:#f3f4f6; padding:16px; border-radius:8px; margin-top:12px;">
                <p style="margin:4px 0;">
                    <strong>Nama Kandidat</strong><br>
                    {{ $data['namaMahasiswa'] }}
                </p>

                <p style="margin:12px 0 4px 0;">
                    <strong>Lowongan</strong><br>
                    {{ $data['namaLowongan'] }}
                </p>
            </div>

            <hr style="border:none; border-top:1px solid #e5e7eb; margin:22px 0;">

            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="padding:6px 0; width:120px;">Tanggal</td>
                    <td>: {{ $data['tanggal'] }}</td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Waktu</td>
                    <td>: {{ $data['mulai'] }} - {{ $data['selesai'] }} WIB</td>
                </tr>

                @if ($data['lokasi'])
                    <tr>
                        <td style="padding:6px 0;">Lokasi</td>
                        <td>: {{ $data['lokasi'] }}</td>
                    </tr>
                @endif

                @if ($data['link'])
                    <tr>
                        <td style="padding:6px 0;">Link</td>
                        <td>:
                            <a href="{{ $data['link'] }}"
                                style="color:#111827; font-weight:bold; text-decoration:none;">
                                Join Meeting
                            </a>
                        </td>
                    </tr>
                @endif
            </table>
            <br>
            <div style="text-align:center;">
                <a href="{{ $data['urlTerima'] }}"
                    style="background:#04aa12; color:white; padding:10px 26px; border-radius:8px; text-decoration:none; font-weight:bold; margin-right:8px; display:inline-block;">
                    TERIMA
                </a>

                <a href="{{ $data['urlTolak'] }}"
                    style="background:#dd0101; color:#ffffff; padding:12px 26px; border-radius:8px; text-decoration:none; font-weight:bold; display:inline-block;">
                    TOLAK
                </a>
            </div>
            <br>
            <div style="background:#f9fafb; padding:14px; border-radius:8px;">
                Mohon memberikan konfirmasi kehadiran Anda dengan menekan tombol di atas.
            </div>

            <br>

            <p style="margin-bottom:0;">Terima kasih.</p>
            <p style="margin-top:4px;"><strong>Tim Rekrutmen</strong></p>
        </div>

        <div style="background:#f9fafb; padding:10px; text-align:center; font-size:12px; color:#6b7280;">
            Sistem Rekrutmen dan Penilaian Student Employee Universitas Surabaya
        </div>
    </div>
</body>

</html>