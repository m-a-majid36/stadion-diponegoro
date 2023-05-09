<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Data Penggajian Karyawan <strong>{{ $data->kode }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Nama Karyawan</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->karyawan->nama }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Nominal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>@rupiah($data->nominal)
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Tanggal Penggajian</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">:
                                </strong>{{ date('d-m-Y', strtotime($data->created_at)) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Periode Penggajian</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">:
                                </strong>{{ date('d-m-Y', strtotime($data->awal)) . ' s/d ' . date('d-m-Y', strtotime($data->akhir)) }}
                            </div>
                        </div>
                        @if ($data->keterangan)
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">Keterangan</div>
                                <div class="col-lg-8 col-md-8"><strong class="text-primary">:
                                    </strong>{{ $data->keterangan }}</div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Basic Modal-->

<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white"><strong>Edit Penggajian {{ $data->kode }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penggajian.update', ['penggajian' => $data->id]) }}" method="POST"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <!-- Kolom From User -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 form-label"><strong>Nomor Kuitansi</strong></div>
                        <div class="col-lg-8 col-md-8">
                            <strong class="text-primary">: </strong>{{ $data->kode }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 form-label"><strong>Nama Karyawan</strong></div>
                        <div class="col-lg-8 col-md-8">
                            <strong class="text-primary">: </strong>{{ $data->karyawan->nama }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 form-label"><strong>Tanggal Penggajian</strong></div>
                        <div class="col-lg-8 col-md-8">
                            <strong class="text-primary">: </strong>{{ date('m-d-Y', strtotime($data->created_at)) }}
                        </div>
                    </div>
                    <hr>
                    <div class="col-12 mb-3">
                        <label for="nominal" class="form-label">Nominal Penggajian (Masukkan Hanya Angka)<span
                                class="text-danger">*</span></label>
                        <input type="text" id="nominal" name="nominal" required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');"
                            class="form-control @error('nominal') is-invalid @enderror" value="@rupiah($data->nominal)">
                        @error('nominal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label text-center">Periode Penggajian</label>
                        <div class="col-6">
                            <label for="awal" class="form-label text-center">Tanggal Awal <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="awal" name="awal" required
                                value="{{ old('awal') ? old('awal') : $data->awal }}"
                                class="form-control @error('awal') is-invalid @enderror">
                            @error('awal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="akhir" class="form-label text-center">Tanggal Akhir <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="akhir" name="akhir" required
                                value="{{ old('akhir') ? old('akhir') : $data->akhir }}"
                                class="form-control @error('akhir') is-invalid @enderror">
                            @error('akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Penggajian</button>
                </div>
            </form>
        </div>
    </div>
</div>
