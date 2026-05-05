@extends('layouts.app')
@section('breadcrumb', 'User Detail')
@section('content')
    <div class ="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10 ">
                <div class="card shadow-sm border-0 rounded-3">
                    @csrf
                    <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white d-flex align-items-center"><i
                                class="material-symbols-rounded text-sm text-white">person</i>&nbsp;&nbsp;Detail User</h5>
                        <div class = "d-flex align-items-center">
                            <a href="{{ route('users.index') }}" class="btn btn-light btn-sm d-flex align-items-center me-2">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="btn  btn-warning btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">edit</i>&nbsp;&nbsp;Edit
                            </a>
                        </div>
                    </div>
                    <div class ="card-body px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Nama Lengkap</div>
                            <div class="col-md-8 text-body-dark">{{ $user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Email</div>
                            <div class="col-md-8 text-body-dark">{{ $user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Role</div>
                            <div class="col-md-8 text-body-dark">{{ $user->role }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Status</div>
                            <div class="col-md-8">
                                @if ($user->status == 1)
                                    <span class="badge bg-success text-white">Aktif</span>
                                @else
                                    <span class="badge bg-danger text-white">Non-Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Created At</div>
                            <div class="col-md-8 text-body-dark">{{ $user->created_at }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-body-secondary">Updated At</div>
                            <div class="col-md-8 text-body-dark">{{ $user->updated_at }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
