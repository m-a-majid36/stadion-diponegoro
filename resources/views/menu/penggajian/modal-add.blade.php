<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><strong>Tambah Penggajian</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penggajian.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <!-- Kolom From User -->
                    <div class="col-12 mb-3">
                        <label for="id_karyawan" class="form-label"><strong>Nama Karyawan </strong><span
                                class="text-danger">*</span></label>
                        <select id="id_karyawan" name="id_karyawan"
                            class="form-select @error('id_karyawan') is-invalid @enderror">
                            <option selected disabled value="0">Pilih Karyawan...</option>
                            @foreach ($karyawan as $data)
                                <option value="{{ $data->id }}"
                                    {{ old('id_karyawan') == $data->id ? 'selected' : '' }}>
                                    {{ $data->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_karyawan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="nominal" class="form-label">Nominal Penggajian (Masukkan Hanya Angka)<span
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
                    <div class="row mb-3">
                        <label class="form-label text-center">Periode Penggajian</label>
                        <div class="col-6">
                            <label for="awal" class="form-label text-center">Tanggal Awal <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="awal" name="awal" required value="{{ old('awal') }}"
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
                            <input type="date" id="akhir" name="akhir" required value="{{ old('akhir') }}"
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
