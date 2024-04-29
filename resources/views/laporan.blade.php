@extends('core.main')
@section('content')
    @if (Session('error') !== null)
        <div class="alert alert-danger" role="alert">
            {{ Session('error') }}
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pilih Periode</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Periode</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Masa Awal</th>
                            <th scope="col">Masa Akhir</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($periodes as $periode)
                            <tr>
                                <td>#</td>
                                <td>Periode {{ $periode->id }}</td>
                                <td>{{ $periode->masa_berlaku_awal }}</td>
                                <td>{{ $periode->masa_berlaku_akhir }}</td>
                                <td>
                                    <a href="{{ url('laporan/' . $periode->id) }}"><button
                                            class="btn btn-primary">Detail</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
