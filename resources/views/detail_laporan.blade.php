@extends('core.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-center">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pendapatan Asli Daerah Tahun {{ $tahun }}</h1>
    </div>
    <div class="d-sm-flex align-items-center justify-content-center">
        <h4 class="h5 mb-0 text-gray-800">{{ $masa_berlaku_awal }} s/d {{ $masa_berlaku_akhir }}</h4>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Target</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
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
                                <td>{{ $data['jumlah_bulan_lalu'] }}</td>
                                <td>{{ $data['jumlah_bulan_ini'] }}</td>
                                <td>{{ $data['jumlah'] }}</td>
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
