@extends('layouts.app')
@section('breadcrumb', 'Staff Unit Detail')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card show-sm border-0 rounded-3">
                    @csrf
                    <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white d-flex align-items-center"><i
                                class="material-symbols-rounded text-sm text-white">corporate_fare</i>&nbsp;&nbsp;Detail Unit
                        </h5>
                        <div class = "d-flex align-items-center">
                            {{-- <a href="{{ route('staff.index') }}" class="btn btn-light btn-sm d-flex align-items-center me-2">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a> --}}
                            <a href="{{ route('staff.edit', $staff->id) }}"
                                class="btn  btn-warning btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">edit</i>&nbsp;&nbsp;Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Nama User</div>
                            <div class="col-md-8 text-body-dark">{{ $staff->user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Nama Unit</div>
                            <div class="col-md-8 text-body-dark">{{ $staff->unit->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Role User</div>
                            <div class="col-md-8 text-body-dark">{{ $staff->user->role }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Email User</div>
                            <div class="col-md-8 text-body-dark">{{ $staff->user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Jabatan</div>
                            <div class="col-md-8 text-body-dark">{{ $staff->jabatan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Status</div>
                            <div class="col-md-8">
                                @if ($staff->status == 1)
                                    <span class="badge bg-success text-white">Aktif</span>
                                @else
                                    <span class="badge bg-danger text-white">Non-Aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
