@extends('layouts.app')
@section('breadcrumb', 'List Kandidat Pengumuman')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                        <h6 class="text-white text-capitalize m-0">List Kandidat - {{ $judulLowongan ?? '-' }}</h6>
                    </div>
                </div>

                <div class="card-body px-2 pb-2">
                    <div class="table-responsive p-0">
                        <table id="tableKandidatPengumuman" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">No</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Nama Kandidat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Nomor Surat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Surat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Status</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Tanggal Publish</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengumuman as $index => $p)
                                    <tr>
                                        <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $p->namaKandidat ?? '-' }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $p->nomor_surat ?? '-' }}</td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($p->file_path)
                                                <a href="{{ asset('storage/' . $p->file_path) }}" target="_blank"
                                                    class="text-decoration-underline fw-medium text-info">
                                                    Lihat
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($p->status == 'Terima')
                                                <span class="badge bg-success px-3 py-2">Lolos</span>
                                            @else
                                                <span class="badge bg-success px-3 py-2">Tolak</span>
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            {{ \Carbon\Carbon::parse($p->tanggal_publish)->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($p->is_publish == 0)
                                                <form action="" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="idPendaftaran"
                                                        value="{{ $p->idPendaftaran }}">

                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Publish
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-success fw-bold">
                                                    Sudah Publish
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableKandidatPengumuman').DataTable({
                language: {
                    emptyTable:"Belum ada kandidat",
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
        });
    </script>
@endpush
