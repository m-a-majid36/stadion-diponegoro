<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><strong>Tambah Data Transaksi</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pembukuan.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <!-- Kolom From User -->
                    <div class="col-12 mb-3">
                        <label for="tgl_transaksi" class="form-label">Tanggal Transaksi<span
                                class="text-danger">*</span></label>
                        <input type="date" id="tgl_transaksi" name="tgl_transaksi" required
                            value="{{ old('tgl_transaksi') }}"
                            class="form-control @error('tgl_transaksi') is-invalid @enderror">
                        @error('tgl_transaksi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <fieldset class="col-12 mb-3">
                        <label for="status" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis" id="status1" value="D"
                                {{ old('jenis') == 'D' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status1">
                                Debit (Pemasukkan)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis" id="status2" value="K"
                                {{ old('jenis') == 'K' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status2">
                                Kredit (Pengeluaran)
                            </label>
                        </div>
                        @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </fieldset>
                    <div class="col-12 mb-3">
                        <label for="nominal" class="form-label">Nominal Transaksi (Masukkan Hanya Angka) <span
                                class="text-danger">*</span></label>
                        <input type="text" id="nominal" name="nominal" required value="{{ old('nominal') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');"
                            class="form-control @error('nominal') is-invalid @enderror">
                        @error('nominal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
