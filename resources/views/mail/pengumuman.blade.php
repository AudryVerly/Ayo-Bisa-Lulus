<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Seleksi</title>
</head>

<body style="margin:0; padding:0; background:#e5e7eb; font-family:Arial, Helvetica, sans-serif;">
    <div
        style="max-width:600px; margin:40px auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.08);">
        <div style="background:#111827; padding:20px;">
            <h2 style="color:white; margin:0;">Hasil Seleksi {{ $lowongan }}</h2>
        </div>

        <div style="padding:20px; color:#374151; font-size:14px; line-height:1.6;">
            <p>Halo, {{ $nama }}</p>
            <p>
                Berdasarkan hasil seleksi untuk posisi
                <b>{{ $lowongan }}</b>, kami informasikan bahwa Anda:
            </p>

            @if ($status == 'Terima')
                <div
                    style="margin:20px 0; padding:15px; background:#ecfdf5; border-left:5px solid #10b981; border-radius:6px;">
                    <p style="margin:0; color:#065f46; font-weight:bold;">
                        🎉 Selamat! Anda LOLOS seleksi
                    </p>
                </div>

                <p>
                    Silakan cek detail lebih lanjut pada sistem dan ikuti instruksi selanjutnya.
                </p>
            @else
                <div
                    style="margin:20px 0; padding:15px; background:#fef2f2; border-left:5px solid #ef4444; border-radius:6px;">
                    <p style="margin:0; color:#7f1d1d; font-weight:bold;">
                        Mohon maaf, Anda BELUM LOLOS seleksi
                    </p>
                </div>

                <p>
                    Terima kasih atas partisipasi Anda. Tetap semangat dan semoga sukses di kesempatan berikutnya.
                </p>
            @endif

            <br>

            <p style="margin-bottom:0;">Terima kasih.</p>
            <p style="margin-top:4px;"><strong>Tim Rekrutmen</strong></p>
        </div>

        <div style="background:#f9fafb; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
            <p style="margin:0;">
                Email ini dikirim secara otomatis oleh sistem.
            </p>
            <p>
                Sistem Rekrutmen dan Penilaian Student Employee Universitas Surabaya
            </p>
        </div>
    </div>
</body>

</html>
