@extends('layout.app')
@section('title', 'Tambah Penyewa')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Tambah Penyewa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('penyewa.index') }}">Data Penyewa</a></li>
                    <li class="breadcrumb-item active">Tambah Penyewa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Create Operator Page -->
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Penyewa</h5>
                        <a href="{{ route('penyewa.index') }}" class="btn btn-warning">
                            <i class="fas fa-angle-double-left"></i>&nbsp; {{ 'Kembali' }}
                        </a>
                        <form action="{{ route('penyewa.store') }}" method="post" enctype="multipart/form-data"
                            class="row">
                            @csrf
                            <!-- Kolom Atas -->
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="nama" name="nama" required value="{{ old('nama') }}"
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
                                    <label for="toko" class="form-label">Nama Toko <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="toko" name="toko" required value="{{ old('toko') }}"
                                        class="form-control @error('toko') is-invalid @enderror">
                                    @error('toko')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="nik" name="nik" required value="{{ old('nik') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        class="form-control @error('nik') is-invalid @enderror">
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="telepon" class="form-label">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                        minlength="9" maxlength="16"
                                        oninput="this.value = this.value.replace(/[^0-9+()]/g, '').replace(/(\+.?)\+.*/g, '$1');"
                                        class="form-control @error('telepon') is-invalid @enderror">
                                    @error('telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="alamat" class="form-label">Alamat (Jalan / RT RW) <span
                                            class="text-danger">*</span></label>
                                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kiri -->
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="province_id" class="form-label">Provinsi <span
                                            class="text-danger">*</span></label>
                                    <select name="province_id" id="province_id" required
                                        class="form-select @error('province_id') is-invalid @enderror">
                                        <option selected disabled>Pilih Provinsi...</option>
                                        @foreach ($provinces as $province_id)
                                            <option value="{{ $province_id->id }}">{{ $province_id->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="regency_id" class="form-label">Kota/Kabupaten <span
                                            class="text-danger">*</span></label>
                                    <select name="regency_id" id="regency_id" required
                                        class="form-select @error('regency_id') is-invalid @enderror">
                                    </select>
                                    @error('regency_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="district_id" class="form-label">Kecamatan <span
                                            class="text-danger">*</span></label>
                                    <select name="district_id" id="district_id" required
                                        class="form-select @error('district_id') is-invalid @enderror">
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3">
                                    <label for="village_id" class="form-label">Kelurahan/Desa <span
                                            class="text-danger">*</span></label>
                                    <select name="village_id" id="village_id" required
                                        class="form-select @error('village_id') is-invalid @enderror">
                                    </select>
                                    @error('village_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Foto KTP -->
                            <div class="col-lg-12">
                                <div class="col-12 mt-3">
                                    <label for="ktp" class="form-label">Foto KTP (Maksimal 2 MB) <span
                                            class="text-danger">*</span></label>
                                    <img class="ktp-preview img-fluid mb-3 text-center">
                                    <input type="file" name="ktp" id="ktp"
                                        class="form-control @error('ktp') is-invalid @enderror" onchange="previewKTP()">
                                    @error('ktp')
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
    <script>
        // KTP Preview
        function previewKTP() {
            const ktp = document.querySelector('#ktp');
            const ktpPreview = document.querySelector('.ktp-preview');

            ktpPreview.style.display = 'block';
            ktpPreview.style.margin = 'auto';
            ktpPreview.width = '500';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(ktp.files[0])

            oFReader.onload = function(oFREvent) {
                ktpPreview.src = oFREvent.target.result;
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function() {
                $('#province_id').on('change', function() {
                    let id_province = $('#province_id').val();

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('penyewa.regencies') }}",
                        data: {
                            id_province: id_province
                        },
                        cache: false,

                        success: function(msg) {
                            $('#regency_id').html(msg);
                            $('#district_id').html('');
                            $('#village_id').html('');
                        },
                        error: function(data) {
                            console.log('error:', data);
                        },
                    });
                });
                $('#regency_id').on('change', function() {
                    let id_regency = $('#regency_id').val();

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('penyewa.districts') }}",
                        data: {
                            id_regency: id_regency
                        },
                        cache: false,

                        success: function(msg) {
                            $('#district_id').html(msg);
                            $('#village_id').html('');
                        },
                        error: function(data) {
                            console.log('error:', data);
                        },
                    });
                });
                $('#district_id').on('change', function() {
                    let id_district = $('#district_id').val();

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('penyewa.villages') }}",
                        data: {
                            id_district: id_district
                        },
                        cache: false,

                        success: function(msg) {
                            $('#village_id').html(msg);
                        },
                        error: function(data) {
                            console.log('error:', data);
                        },
                    });
                });
            });
        });
    </script>
@endsection
