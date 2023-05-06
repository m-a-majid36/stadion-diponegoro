<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white"><strong>Data Pembayaran Ruko</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">Nama Penyewa</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->penyewa->nama }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Kode Ruko</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->ruko->kode }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Nominal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>@rupiah($data->nominal)
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Tanggal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">:
                                </strong>{{ date('d-m-Y', strtotime($data->created_at)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Status</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                @if ($data->status == 'baru')
                                    <span class="badge bg-primary">DP (Tanda Jadi)</span>
                                @elseif ($data->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif ($data->status == 'cicil')
                                    <span class="badge bg-info">Sebagian</span>
                                @elseif ($data->status == 'telat')
                                    <span class="badge bg-warning">Telat</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Batas bayar berikutnya</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">:
                                </strong>{{ date('d-m-Y', strtotime($data->deadline)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Keterangan</div>
                            <div class="col-lg-8 col-md-8"><strong class="text-primary">:
                                </strong>{{ $data->keterangan }}</div>
                        </div>

                        @if ($data->file)
                            <div class="mt-3 text-center">
                                <img src="{{ Storage::url($data->file) }}" width="350">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white"><strong>Edit Pembayaran {{ $data->kode }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pembayaran.update', ['pembayaran' => $data->id]) }}" method="POST"
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
                        <div class="col-lg-4 col-md-4 form-label"><strong>Kode Ruko</strong></div>
                        <div class="col-lg-8 col-md-8">
                            <strong class="text-primary">: </strong>{{ $data->ruko->kode }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 form-label"><strong>Nama Penyewa</strong></div>
                        <div class="col-lg-8 col-md-8">
                            <strong class="text-primary">: </strong>{{ $data->penyewa->nama }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 form-label"><strong>Nama Toko</strong></div>
                        <div class="col-lg-8 col-md-8">
                            <strong class="text-primary">: </strong>{{ $data->penyewa->toko }}
                        </div>
                    </div>
                    <hr>
                    <div class="col-12 mb-3">
                        <label for="nominal" class="form-label">Nominal Pembayaran (Masukkan Hanya Angka)<span
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
                    <fieldset class="col-12 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1"
                                value="baru" {{ $data->status == 'baru' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status1">
                                Tanda Jadi (DP)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2"
                                value="lunas" {{ $data->status == 'lunas' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status2">
                                Lunas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status3"
                                value="cicil" {{ $data->status == 'cicil' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status3">
                                Sebagian/Menyicil
                            </label>
                        </div>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </fieldset>
                    <div class="col-12 mb-3">
                        <label for="deadline" class="form-label">Batas Pembayaran Berikutnya <span
                                class="text-danger">*</span></label>
                        <input type="date" id="deadline" name="deadline" required value="{{ $data->deadline }}"
                            class="form-control @error('deadline') is-invalid @enderror">
                        @error('deadline')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if ($data->file)
                        <div class="mt-3 mb-3 text-center">
                            <img src="{{ Storage::url($data->file) }}" width="350">
                            <input type="hidden" name="oldGambar" id="oldGambar" value="{{ $data->file }}">
                        </div>
                    @endif
                    <div class="col-12 mb-3">
                        <label for="bukti_bayar" class="form-label">
                            @if ($data->file)
                                Ganti Gambar (bila ada)
                            @else
                                Tambah Gambar (bila ada)
                            @endif
                        </label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar"
                            class="form-control @error('bukti_bayar') is-invalid @enderror">
                        @error('bukti_bayar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
