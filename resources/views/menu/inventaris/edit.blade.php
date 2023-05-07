@extends('layout.app')
@section('title', 'Edit Inventaris')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Edit Inventaris</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventaris.index') }}">Data Inventaris</a></li>
                    <li class="breadcrumb-item active">Edit Inventaris</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Create Operator Page -->
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Data Inventaris</h5>
                        <a href="{{ route('inventaris.index') }}" class="btn btn-warning">
                            <i class="fas fa-angle-double-left"></i>&nbsp; {{ 'Kembali' }}
                        </a>
                        <form action="{{ route('inventaris.update', $inventaris->id) }}" method="post"
                            enctype="multipart/form-data" class="row">
                            @csrf
                            @method('PUT')
                            <!-- Kolom Atas -->
                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="nama" class="form-label">Nama Barang <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="nama" name="nama" required
                                        value="{{ old('nama') ? old('nama') : $inventaris->nama }}"
                                        class="form-control @error('nama') is-invalid @enderror">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="tanggal" class="form-label">Tanggal Pengadaan <span
                                            class="text-danger">*</span></label>
                                    <input type="date" id="tanggal" name="tanggal" required
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal') ? old('tanggal') : $inventaris->tanggal }}">
                                    @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="kode" class="form-label">Kode Inventaris <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="kode" name="kode" required
                                        value="{{ old('kode') ? old('kode') : $inventaris->kode }}"
                                        class="form-control @error('kode') is-invalid @enderror">
                                    @error('kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="harga" class="form-label">Harga Satuan (Masukkan Hanya Angka) <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('harga') is-invalid @enderror" type="text"
                                        id="harga" name="harga" required value="@rupiah($inventaris->harga)"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');">
                                    @error('harga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="jumlah" class="form-label">Jumlah Barang (Masukkan Hanya Angka) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="jumlah" name="jumlah" required
                                        value="{{ old('jumlah') ? old('jumlah') : $inventaris->jumlah }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        class="form-control @error('jumlah') is-invalid @enderror">
                                    @error('jumlah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Foto Gambar -->
                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="gambar" class="form-label">Dokumentasi (bila ada)</label>
                                    <input type="hidden" name="oldGambar" value="{{ $inventaris->gambar }}">
                                    @if ($inventaris->gambar)
                                        <img src="{{ Storage::url($inventaris->gambar) }}" height="250" width="250"
                                            class="gambar-preview img-fluid mb-3 text-center d-block">
                                    @else
                                        <img class="gambar-preview img-fluid mb-3 text-center">
                                    @endif
                                    <input type="file" name="gambar" id="gambar" onchange="previewGambar()"
                                        class="form-control @error('gambar') is-invalid @enderror">
                                    @error('gambar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Keterangan -->
                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') ? old('keterangan') : $inventaris->keterangan }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary text-center">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- / Content -->
@endsection
@section('script')
    <script type="text/javascript">
        var harga = document.getElementById('harga');
        harga.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatHarga() untuk mengubah angka yang di ketik menjadi format angka
            harga.value = formatHarga(this.value, 'Rp. ');
        });

        /* Fungsi formatHarga */
        function formatHarga(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                harga = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                harga += separator + ribuan.join('.');
            }

            harga = split[1] != undefined ? harga + ',' + split[1] : harga;
            return prefix == undefined ? harga : (harga ? 'Rp. ' + harga : '');
        }
    </script>
    <script>
        // Gambar Preview
        function previewGambar() {
            const gambar = document.querySelector('#gambar');
            const gambarPreview = document.querySelector('.gambar-preview');

            gambarPreview.style.display = 'block';
            gambarPreview.style.margin = 'auto';
            gambarPreview.width = '500';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(gambar.files[0])

            oFReader.onload = function(oFREvent) {
                gambarPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
