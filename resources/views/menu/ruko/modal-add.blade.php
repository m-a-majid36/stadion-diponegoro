<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><strong>Tambah Ruko</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ruko.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <!-- Kolom From User -->
                    <div class="col-12 mb-3">
                        <label for="kode" class="form-label">Kode Ruko <span class="text-danger">*</span></label>
                        <input type="text" id="kode" name="kode" required value="{{ old('kode') }}"
                            class="form-control @error('kode') is-invalid @enderror">
                        @error('kode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Tarif/Harga Ruko <span
                                class="text-danger">*</span></label>
                        <input type="text" id="tarif" name="tarif" required value="{{ old('tarif') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');"
                            class="form-control @error('tarif') is-invalid @enderror">
                        @error('tarif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
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
                    <button type="submit" class="btn btn-primary">Tambah Ruko</button>
                </div>
            </form>
        </div>
    </div>
</div>
