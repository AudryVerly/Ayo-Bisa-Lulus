@extends('layouts.app')
@section('breadcrumb', 'Formulir Pendaftaran')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-15">
                <div class="card shadow-sm border-0 rounded-3">
                    {{-- pakai enctype supaya bisa upload --}}
                    <form action="{{ route('pendaftaran.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data"
                        novalidate>
                        @csrf
                        <div class="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">contract</i>&nbsp;&nbsp; Formulir
                                Lowongan {{ $lowongan->judulLowongan }}
                            </h5>
                            {{-- <a href="{{ route('mahasiswa.dashboard') }}"
                                class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a> --}}
                        </div>
                        @if (session('success'))
                            <div id ="alert-message" class="alert alert-success alert-dismissible text-white"
                                role="alert">
                                {{ session('success') }}</div>
                        @elseif (session('error'))
                            <div id ="alert-message" class="alert alert-danger alert-dismissible text-white" role="alert">
                                {{ session('error') }}</div>
                        @endif
                        <div class="card-body px-4 py-4">
                            @foreach ($fieldFormulir as $field)
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        {{ $field->namaField }}
                                        @if ($field->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if ($field->tipeField === 'text')
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="field[{{ $field->id }}]"
                                                class="form-control @error('field.' . $field->id) is-invalid @enderror"
                                                value="{{ old('field.' . $field->id) }}"
                                                {{ $field->required ? 'required' : '' }}>
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'number')
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="field[{{ $field->id }}]"
                                                placeholder="Angka dapat berupa desimal" pattern="^[0-9]+([,.][0-9]+)?$"
                                                inputmode="decimal" {{ $field->required ? 'required' : '' }}
                                                class="form-control @error('field.' . $field->id) is-invalid @enderror"
                                                value="{{ old('field.' . $field->id) }}">
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'date')
                                        <div class="input-group input-group-outline">
                                            <input type="date" name="field[{{ $field->id }}]"
                                                class="form-control @error('field.' . $field->id) is-invalid @enderror"
                                                {{ $field->required ? 'required' : '' }}
                                                value="{{ old('field.' . $field->id) }}">
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif ($field->tipeField === 'textarea')
                                        <div class="input-group input-group-outline">
                                            <textarea name="field[{{ $field->id }}]" rows="5"
                                                class="form-control @error('field.' . $field->id) is-invalid @enderror" {{ $field->required ? 'required' : '' }}>{{ old('field.' . $field->id) }}</textarea>
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'select')
                                        <select name="field[{{ $field->id }}]"
                                            class="form-select px-2 py-2 @error('field.' . $field->id) is-invalid @enderror"
                                            {{ $field->required ? 'required' : '' }}>
                                            <option value="">Pilih {{ $field->namaField }}</option>
                                            @foreach (explode(',', $field->opsi_field) as $opsi)
                                                <option value="{{ trim($opsi) }}"
                                                    {{ old('field.' . $field->id) == trim($opsi) ? 'selected' : '' }}>
                                                    {{ trim($opsi) }}</option>
                                            @endforeach
                                        </select>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'radio')
                                        <div class="d-flex flex-wrap gap-4 mt-2">
                                            @foreach (explode(',', $field->opsi_field) as $opsi)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="field[{{ $field->id }}]" value="{{ trim($opsi) }}"
                                                        {{ old('field.' . $field->id) == trim($opsi) ? 'checked' : '' }}
                                                        {{ $field->required ? 'required' : '' }}>
                                                    <label class="form-check-label">
                                                        {{ trim($opsi) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'checkbox')
                                        <div class="d-flex flex-wrap gap-4 mt-2">
                                            @foreach (explode(',', $field->opsi_field) as $opsi)
                                                <div class="form-check">
                                                    <input type="checkbox" name="field[{{ $field->id }}][]"
                                                        value="{{ trim($opsi) }}"
                                                        {{ in_array(trim($opsi), old('field.' . $field->id, [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label">
                                                        {{ trim($opsi) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'phone')
                                        <div class="input-group input-group-outline">
                                            <input type="tel" name="field[{{ $field->id }}]"
                                                class="form-control @error('field.' . $field->id) is-invalid @enderror"
                                                placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}"
                                                value="{{ old('field.' . $field->id) }}"
                                                {{ $field->required ? 'required' : '' }}>
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @elseif($field->tipeField === 'file')
                                        <div class="input-group input-group-outline mt-2">
                                            <input type="file" name="field[{{ $field->id }}]"
                                                class="form-control  @error('field.' . $field->id) is-invalid @enderror"
                                                id="file_{{ $field->id }}" {{ $field->required ? 'required' : '' }}
                                                onchange="showFileName(this)">
                                        </div>
                                        @error('field.' . $field->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                            {{-- submit --}}
                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success">
                                    <i class="material-symbols-rounded text-sm">send</i>
                                    Kirim Pendaftaran
                                </button>
                                <a href="{{ route('.index') }}" class="btn bg-gradient-danger text-white px-4">
                                    <i class="material-symbols-rounded text-sm">close</i><span
                                        class="align-middle">&nbsp;&nbsp;Batal</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        //kalau ini supaya alertnya hilang dalam 2 detik 
        setTimeout(() => {
            const alert = document.getElementById('alert-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); //hapus elemen setelah fade out
            }
        }, 5000); //muncul selama 5 detik
    </script>
@endpush
