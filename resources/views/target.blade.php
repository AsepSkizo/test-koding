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
        <h1 class="h3 mb-0 text-gray-800">Data Target</h1>
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">+ Tambah Target</button>
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
                            <th scope="col">No</th>
                            <th scope="col">Kode Rekening</th>
                            <th scope="col">Nama Rekening</th>
                            <th scope="col">Target (Rp.)</th>
                            <th scope="col">Masa Berlaku</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($targets as $target)
                            <tr>
                                <th scope="row">#</th>
                                <td>{{ $target->rekening->kode_rekening }}</td>
                                <td>{{ $target->rekening->nama_rekening }}</td>
                                <td>{{ number_format($target->target, '0', ',', '.') }}</td>
                                <td>{{ $target->periode->masa_berlaku_awal }} sd {{ $target->periode->masa_berlaku_akhir }}
                                </td>
                                <td>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#ubahModal"
                                        class="btn btn-warning my-1"
                                        onclick="update('{{ $target->rekening->id }}', '{{ $target->periode->id }}','{{ $target->target }}', '{{ $target->id }}')">Edit</button>
                                    <form action="{{ route('target.delete') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{ $target->id }}" name="id">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus target?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Target --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Tambah Target</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('target.tambah') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rekening" class="form-label">Rekening</label>
                            <select name="rekening" class="form-control" id="rekening">
                                @foreach ($rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->nama_rekening }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="periode" class="form-label">Periode</label>
                            <select name="periode" class="form-control" id="periode">
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->masa_berlaku_awal }} sd
                                        {{ $periode->masa_berlaku_akhir }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="target" class="form-label">Target</label>
                            <input type="number" min="0" name="target" id="target" class="form-control">
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
    {{-- Modal Ubah Target --}}
    <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="ubahModalLabel">Edit Target</h4>
                    <button type="button" class="btn btn-block col-1" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('target.edit') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rekeningUbah" class="form-label">Rekening</label>
                            <select name="rekening" class="form-control" id="rekeningUbah">
                                @foreach ($rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->nama_rekening }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="periodeUbah" class="form-label">Periode</label>
                            <select name="periode" class="form-control" id="periodeUbah">
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->masa_berlaku_awal }} sd
                                        {{ $periode->masa_berlaku_akhir }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="targetUbah" class="form-label">Target</label>
                            <input type="number" min="0" name="target" id="targetUbah" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="idTarget" id="idUbah">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function update(idRekening, idPeriode, target, idTarget) {
            document.getElementById("rekeningUbah").value = idRekening;
            document.getElementById("periodeUbah").value = idPeriode;
            document.getElementById("targetUbah").value = target;
            document.getElementById("idUbah").value = idTarget;
        }
    </script>
@endsection
