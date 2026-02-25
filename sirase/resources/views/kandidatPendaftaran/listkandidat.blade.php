@extends('layouts.app')
@section('breadcrumb', 'List Kandidat')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Lowongan</h6>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableListKandidat" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <table id="tableListKandidat" class="table align-items-center mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">No</th>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">Kandidat</th>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">NRP</th>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">Tanggal Daftar</th>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">Status Pendaftaran</th>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">Tahapan</th>
                                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
