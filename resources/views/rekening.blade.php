@extends('core.main')
@section('content')
    @if (Session('success') !== null)
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    @if (Session('error') !== null)
        <div class="alert alert-danger" role="alert">
            {{ Session('error') }}
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Rekening</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">+ Tambah Rekening</button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rekening</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Rekening</th>
                            <th scope="col">Kode Rekening</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekenings as $rekening)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{ $rekening['nama_rekening'] }}</td>
                                <td>{{ $rekening['kode_rekening'] }}</td>
                                <td>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#rekeningUpdate"
                                        class="btn btn-warning my-1"
                                        onclick="update('{{ $rekening['kode_rekening'] }}', '{{ $rekening['nama_rekening'] }}')">Edit</button>
                                    <form action="{{ route('rekening.delete') }}" class="">
                                        <input type="hidden" value="{{ $rekening['kode_rekening'] }}" name="kode_rekening">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus kode rekening?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- Modal Tambah Rekening --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Tambah Rekening</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('rekening.tambah') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaRekening" class="form-label">Nama Rekening</label>
                            <input type="text" class="form-control" id="namaRekening" name="nama_rekening"
                                placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="kodeRekening" class="form-label">Kode Rekening</label>
                            <input type="text" class="form-control" id="kodeRekening" name="kode_rekening"
                                placeholder="">
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

    {{-- Modal Ubah Rekening --}}
    <div class="modal fade" id="rekeningUpdate" tabindex="-1" aria-labelledby="rekeningUpdateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="rekeningUpdateLabel">Ubah Rekening</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('rekening.edit') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaRekeningUpdate" class="form-label">Nama Rekening</label>
                            <input type="text" class="form-control" id="namaRekeningUpdate" name="nama_rekening"
                                placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="kodeRekeningUpdate" class="form-label">Kode Rekening</label>
                            <input type="text" class="form-control" id="kodeRekeningUpdate" name="kode_rekening"
                                placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning"
                            onclick="return confirm('Apakah Anda Ingin menyimpan perubahan?')">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function update(kode_rekening, nama_rekening) {
            document.getElementById('kodeRekeningUpdate').value = kode_rekening;
            document.getElementById('namaRekeningUpdate').value = nama_rekening;
        }
    </script>
@endsection
