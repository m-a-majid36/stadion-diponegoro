<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><strong>Tambah Pembayaran</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pembayaran.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <!-- Kolom From User -->
                    <div class="col-12 mb-3">
                        <label for="id_ruko" class="form-label"><strong>Kode Ruko </strong><span
                                class="text-danger">*</span></label>
                        <select id="id_ruko" name="id_ruko"
                            class="form-select @error('id_ruko') is-invalid @enderror">
                            <option selected disabled value="0">Pilih Ruko...</option>
                            @foreach ($ruko as $data)
                                <option value="{{ $data->id }}" {{ old('id_ruko') == $data->id ? 'selected' : '' }}>
                                    {{ $data->kode }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_ruko')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="nama" class="form-label">Nama Penyewa <span class="text-danger">*</span></label>
                        <div id="nama">
                            <input type="text" readonly class="form-control">
                        </div>
                        <div id="id_penyewa">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="toko" class="form-label">Nama Toko <span class="text-danger">*</span></label>
                        <div id="toko">
                            <input type="text" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="nominal" class="form-label">Nominal Pembayaran (Masukkan Hanya Angka)<span
                                class="text-danger">*</span></label>
                        <input type="text" id="nominal" name="nominal" required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            class="form-control @error('nominal') is-invalid @enderror">
                        @error('nominal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <fieldset class="col-12 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="baru"
                                {{ old('status') == 'baru' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status1">
                                Tanda Jadi (DP)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="lunas"
                                {{ old('status') == 'lunas' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status2">
                                Lunas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status3" value="cicil"
                                {{ old('status') == 'cicil' ? 'checked' : '' }}>
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
                        <label for="deadline" class="form-label">Batas Pembayaran Berikutnya<span
                                class="text-danger">*</span></label>
                        <input type="date" id="deadline" name="deadline" required value="{{ old('deadline') }}"
                            class="form-control @error('deadline') is-invalid @enderror">
                        @error('deadline')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
