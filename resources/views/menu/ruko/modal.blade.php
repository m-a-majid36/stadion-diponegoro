<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><strong>Edit Ruko {{ $data->kode }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ruko.update', ['ruko' => $data->id]) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <!-- Kolom From User -->
                    @if ($data->id_penyewa != 0)
                        <div class="col-12 mb-3">
                            <label for="penyewa" class="form-label">Penyewa</label>
                            <input type="text" readonly class="form-control" value="{{ $data->penyewa->nama }}">
                        </div>
                    @endif
                    <div class="col-12 mb-3">
                        <label for="kode" class="form-label">Kode Ruko <span class="text-danger">*</span></label>
                        <input type="text" id="kode" name="kode" required
                            value="{{ old('kode') ? old('kode') : $data->kode }}"
                            class="form-control @error('kode') is-invalid @enderror">
                        @error('kode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="tarif" class="form-label">Tarif/Harga Ruko <span
                                class="text-danger">*</span></label>
                        <input type="text" id="tarif" name="tarif"
                            class="form-control @error('tarif') is-invalid @enderror" required value="@rupiah($data->tarif)"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');">
                        @error('tarif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                        <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') ? old('keterangan') : $data->keterangan }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Ruko</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Apakah anda yakin menghapus Ruko ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Jika anda yakin ingin menghapus Ruko <strong>{{ $data->kode }}</strong>, Tekan Oke!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('ruko.destroy', $data->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Oke</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

<!-- Sewa Modal -->
<div class="modal fade" id="sewaModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">Tambah Penyewa Ruko <strong>{{ $data->kode }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ruko.sewa', ['ruko' => $data->id]) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <!-- Kolom From User -->
                    <div class="col-12 mb-3">
                        <label for="kode" class="form-label">Nama Penyewa <span class="text-danger">*</span></label>
                        <select name="id_penyewa" id="id_penyewa" class="form-select" required>
                            <option selected disabled value="0">Pilih Penyewa...</option>
                            @foreach ($penyewa as $data)
                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Sewakan Ruko</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- End Basic Modal-->
