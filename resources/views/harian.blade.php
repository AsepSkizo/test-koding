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
        <h1 class="h3 mb-0 text-gray-800">Data Entry Harian</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">+ Tambah Entry</button>
    </div>
    @if (isset($query))
        <p>Result from "{{ $query }}"</p>
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
                <form action="{{ url('harian/search') }}" method="POST">
                    @csrf
                    @method('post')
                    <input type="text" class="form-control mb-3" name="query"
                        placeholder="Cari Berdasarkan Kode dan Nama Rekening">
                    <button class="btn-primary btn col-12">Cari</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Harian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Rekening</th>
                            <th scope="col">Nama Rekening</th>
                            <th scope="col">Via Bayar</th>
                            <th scope="col">Tanggal Setor</th>
                            <th scope="col">Jumlah Bayar (Rp.)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($harians as $harian)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{ $harian->rekening->kode_rekening }}</td>
                                <td>{{ $harian->rekening->nama_rekening }}</td>
                                <td>{{ $harian->via }}
                                </td>
                                <td>{{ $harian->tanggal }}</td>
                                <td>{{ number_format($harian->jumlah, '0', ',', '.') }}</td>
                                <td>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#ubahModal"
                                        class="btn btn-warning my-1"
                                        onclick="update('{{ $harian->rekening->id }}', '{{ $harian->via }}','{{ $harian->jumlah }}', '{{ $harian->tanggal }}', '{{ $harian->id }}')">Edit</button>
                                    <form action="{{ route('harian.delete') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{ $harian->id }}" name="id">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus entry?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Entry --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Tambah Entry</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('harian.tambah') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rekening" class="form-label">Rekening</label>
                            <select name="rekening" class="form-control" id="rekening">
                                @foreach ($rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->kode_rekening }}
                                        ({{ $rekening->nama_rekening }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="via" class="form-label">Via Bayar</label>
                            <select name="via" id="" class="form-control">
                                <option value="Bank">Bank</option>
                                <option value="Bendahara">Bendahara</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tgl" class="form-label">Tanggal Setor</label>
                            <input type="date" name="tanggal" id="tgl" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label for="jml" class="form-label">Jumlah</label>
                            <input type="number" min="1" name="jumlah" id="jml" class="form-control">
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
    {{-- Modal Ubah Entry --}}
    <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Tambah Entry</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <form action="{{ route('harian.edit') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rekeningUbah" class="form-label">Rekening</label>
                            <select name="rekening" class="form-control" id="rekeningUbah">
                                @foreach ($rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->kode_rekening }}
                                        ({{ $rekening->nama_rekening }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="viaUbah" class="form-label">Via Bayar</label>
                            <select name="via" id="viaUbah" class="form-control">
                                <option value="Bank">Bank</option>
                                <option value="Bendahara">Bendahara</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tglUbah" class="form-label">Tanggal Setor</label>
                            <input type="date" name="tanggal" id="tglUbah" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label for="jmlUbah" class="form-label">Jumlah</label>
                            <input type="number" min="1" name="jumlah" id="jmlUbah" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="id" id="idUbah">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let today = new Date().toISOString().slice(0, 10)

        document.getElementById("tgl").value = today;

        function update(rekeningId, via, jumlah, tanggal, id) {
            document.getElementById("rekeningUbah").value = rekeningId;
            document.getElementById("viaUbah").value = via;
            document.getElementById("jmlUbah").value = jumlah;
            document.getElementById("tglUbah").value = tanggal;
            document.getElementById("idUbah").value = id;
        }
    </script>
@endsection
