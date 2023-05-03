@extends('layout.app')
@section('title', 'Tambah Pembukuan')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Tambah Data Transaksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tambah Pembukuan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Create Operator Page -->
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Transaksi Pembukuan</h5>
                        <form action="{{ route('pembukuan.store') }}" method="post" enctype="multipart/form-data"
                            class="row">
                            @csrf
                            <!-- Kolom Atas -->
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="tgl_transaksi" class="form-label">Tanggal Transaksi<span
                                            class="text-danger">*</span></label>
                                    <input type="date" id="tgl_transaksi" name="tgl_transaksi" required
                                        value="{{ old('tgl_transaksi') }}"
                                        class="form-control @error('tgl_transaksi') is-invalid @enderror">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="nominal" class="form-label">Nominal Transaksi (Masukkan Hanya Angka) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="nominal" name="nominal" required
                                        value="{{ old('nominal') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');"
                                        class="form-control @error('nominal') is-invalid @enderror">
                                    @error('nominal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <fieldset class="col-12 mt-3">
                                    <label for="status" class="form-label">Jenis <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis" id="status1"
                                            value="D" {{ old('jenis') == 'D' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status1">
                                            Debit (Pemasukkan)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis" id="status2"
                                            value="K" {{ old('jenis') == 'K' ? 'checked' : '' }}>
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
                            </div>

                            <!-- Kolom Foto KTP -->
                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="gambar" class="form-label">Foto/Dokumentasi (jika ada)</label>
                                    <img class="gambar-preview img-fluid mb-3 text-center">
                                    <input type="file" name="gambar" id="gambar"
                                        class="form-control @error('gambar') is-invalid @enderror"
                                        onchange="previewGambar()">
                                    @error('gambar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Deskripsi -->
                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="deskripsi" class="form-label">Deskripsi <span
                                            class="text-danger">*</span></label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
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
                                    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary text-center">Submit</button>
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
        var nominal = document.getElementById('nominal');
        nominal.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatNominal() untuk mengubah angka yang di ketik menjadi format angka
            nominal.value = formatNominal(this.value, 'Rp. ');
        });

        /* Fungsi formatNominal */
        function formatNominal(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                nominal = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                nominal += separator + ribuan.join('.');
            }

            nominal = split[1] != undefined ? nominal + ',' + split[1] : nominal;
            return prefix == undefined ? nominal : (nominal ? 'Rp. ' + nominal : '');
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
