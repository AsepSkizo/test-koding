@extends('core.main')
@section('content')
    @if (Session('success') !== null)
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Periode</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">+ Tambah Periode</button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Periode</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                                role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" style="width: 160px;">Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="awal: activate to sort column ascending"
                                            style="width: 246px;">Masa Awal</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="akhir: activate to sort column ascending"
                                            style="width: 114px;">Masa Akhir</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="aksi: activate to sort column ascending"
                                            style="width: 50px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Masa Awal</th>
                                        <th rowspan="1" colspan="1">Masa Akhir</th>
                                        <th rowspan="1" colspan="1">Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($periodes as $periode)
                                        <tr class="odd">
                                            <td class="sorting_1">Periode {{ $periode['id'] }}</td>
                                            <td>{{ $periode['masa_berlaku_awal'] }}</td>
                                            <td>{{ $periode['masa_berlaku_akhir'] }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Periode --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Tambah Periode</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('periode.tambah') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="masaAwal" class="form-label">Masa Berlaku Awal</label>
                            <input type="date" class="form-control" id="masaAwal" name="masa_awal" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="masaAkhir" class="form-label">Masa Berlaku Akhir</label>
                            <input type="date" class="form-control" id="masaAkhir" name="masa_akhir" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
