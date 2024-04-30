@extends('core.main')
@section('content')
    @if (Session('error') !== null)
        <div class="alert alert-danger" role="alert">
            {{ Session('error') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Search</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse" id="collapseCardExample" style="">
            <div class="card-body">
                <form action="{{ url("laporan/$id_periode/search") }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="mb-3 col-sm-4">
                            <label for="rekening" class="form-label">Tanggal Awal</label>
                            <input type="date" name="awal" class="form-control">
                        </div>
                        <div class="mb-3 col-sm-4">
                            <label for="rekening" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="akhir" class="form-control">
                        </div>
                        <div class="mb-3 col-sm-4">
                            <label for="rekening" class="form-label">Pembayaran</label>
                            <select name="via" class="form-control" id="">
                                <option value=""></option>
                                <option value="Bank">Bank</option>
                                <option value="Bendahara">Bendahara</option>
                            </select>
                        </div>
                        <input type="hidden" value="{{ $id_periode }}" name="periode">
                    </div>
                    <button class="btn-primary btn col-12">Cari</button>
                </form>
            </div>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-center">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pendapatan Asli Daerah {{ $via ? "Via $via" : '' }} Tahun
            {{ $tahun }}
        </h1>
    </div>
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h4 class="h5 mb-0 text-gray-800">{{ $masa_berlaku_awal }} s/d {{ $masa_berlaku_akhir }}</h4>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Target</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" rowspan="2">No</th>
                            <th scope="col" rowspan="2">Kode Rekening</th>
                            <th scope="col" rowspan="2">Nama Rekening</th>
                            <th scope="col" rowspan="2">Target (Rp.)</th>
                            <th scope="col" colspan="3">Realisasi</th>
                            <th scope="col" rowspan="2">%</th>
                        </tr>
                        <tr>
                            <th>s/d Bulan Lalu</th>
                            <th>Bulan Ini</th>
                            <th>s/d Bulan Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{ $data['rekening']->kode_rekening }}</td>
                                <td>{{ $data['rekening']->nama_rekening }}</td>
                                <td>{{ number_format($data['target'], '0', ',', '.') }}</td>
                                <td>{{ number_format($data['jumlah_bulan_lalu'], '0', ',', '.') }}</td>
                                <td>{{ number_format($data['jumlah_bulan_ini']), '0', ',', '.' }}</td>
                                <td>{{ number_format($data['jumlah'], '0', ',', '.') }}</td>
                                <td>
                                    {{ round(($data['jumlah'] / $data['target']) * 100, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
