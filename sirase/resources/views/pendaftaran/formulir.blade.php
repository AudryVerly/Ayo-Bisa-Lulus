@extends('layouts.app')
@section('breadcrumb', 'Formulir Pendaftaran')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-15">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="" method="POST">
                        @csrf
                        <div class="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">contract</i>&nbsp;&nbsp; Formulir
                                Lowongan {{ $lowongan->judulLowongan }}
                            </h5>
                            <a href="{{ route('mahasiswa.dashboard') }}"
                                class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a>
                        </div>
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
                                            <input type="text" nama="field[{{ $field->id }}]" class="form-control"
                                                {{ $field->required ? 'required' : '' }}>
                                        </div>
                                    @elseif($field->tipeField === 'number')
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="field[{{ $field->id }}]"
                                                placeholder="Angka dapat berupa desimal" pattern="^[0-9]+([,.][0-9]+)?$"
                                                inputmode="decimal" {{ $field->required ? 'required' : '' }}
                                                class="form-control">
                                        </div>
                                    @elseif($field->tipeField === 'date')
                                        <div class="input-group input-group-outline">
                                            <input type="date" name="field[{{ $field->id }}]" class="form-control"
                                                {{ $field->required ? 'required' : '' }}>
                                        </div>
                                    @elseif ($field->tipeField === 'textarea')
                                        <div class="input-group input-group-outline">
                                            <textarea name="field[{{ $field->id }}]" rows="5" class="form-control"
                                                {{ $field->required ? 'required' : '' }}></textarea>
                                        </div>
                                    @elseif($field->tipeField === 'select')
                                        <select name="field[{{ $field->id }}]" class="form-select px-2 py-2"
                                            {{ $field->required ? 'required' : '' }}>
                                            <option value="">Pilih {{ $field->namaField }}</option>
                                            @foreach (explode(',', $field->opsi_field) as $opsi)
                                                <option value="{{ trim($opsi) }}">{{ trim($opsi) }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($field->tipeField === 'radio')
                                        <div class="d-flex flex-wrap gap-4 mt-2">
                                            @foreach (explode(',', $field->opsi_field) as $opsi)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="field[{{ $field->id }}]" value="{{ trim($opsi) }}"
                                                        {{ $field->required ? 'required' : '' }}>
                                                    <label class="form-check-label">
                                                        {{ trim($opsi) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($field->tipeField === 'checkbox')
                                        <div class="d-flex flex-wrap gap-4 mt-2">
                                            @foreach (explode(',', $field->opsi_field) as $opsi)
                                                <div class="form-check">
                                                    <input type="checkbox" name="field[{{ $field->id }}][]"
                                                        value="{{ trim($opsi) }}">
                                                    <label class="form-check-label">
                                                        {{ trim($opsi) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($field->tipeField === 'phone')
                                        <div class="input-group input-group-outline">
                                            <input type="tel" name="field[{{ $field->id }}]" class="form-control"
                                                placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}"
                                                {{ $field->required ? 'required' : '' }}>
                                        </div>
                                    @elseif($field->tipeField === 'file')
                                        <div class="input-group input-group-outline mt-2">
                                            <input type="file" name="field[{{ $field->id }}]" class="form-control"
                                                id="file_{{ $field->id }}" {{ $field->required ? 'required' : '' }}
                                                onchange="showFileName(this)">
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            {{-- submit --}}
                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-dark">
                                    <i class="material-symbols-rounded text-sm">send</i>
                                    Kirim Pendaftaran
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
