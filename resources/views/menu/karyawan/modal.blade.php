<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white"><strong>Detail Karyawan {{ $data->nama }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">Nama</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->nama }}
                            </div>
                        </div>

                        @if ($data->nik)
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">NIK</div>
                                <div class="col-lg-8 col-md-8">
                                    <strong class="text-primary">: </strong>{{ $data->nik }}
                                </div>
                            </div>
                        @endif

                        @if ($data->telepon)
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">No. Telepon</div>
                                <div class="col-lg-8 col-md-8">
                                    <strong class="text-primary">: </strong>{{ $data->telepon }}
                                </div>
                            </div>
                        @endif

                        @if ($data->alamat)
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">Alamat</div>
                                <div class="col-lg-8 col-md-8">
                                    <strong class="text-primary">: </strong>{{ $data->alamat }}
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Provinsi</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ ucfirst(strtolower($data->province->name)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Kab./Kota</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ ucfirst(strtolower($data->regency->name)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Kecamatan</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ ucfirst(strtolower($data->district->name)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Kel./Desa</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ ucfirst(strtolower($data->village->name)) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Tanggal Mulai Kerja</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ date('d-m-Y', strtotime($data->mulai)) }}
                            </div>
                        </div>

                        @if ($data->status == 'N')
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">Tanggal Berhenti Kerja</div>
                                <div class="col-lg-8 col-md-8">
                                    <strong class="text-primary">:
                                    </strong>{{ date('d-m-Y', strtotime($data->selesai)) }}
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Status</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                @if ($data->status == 'A')
                                    <span class="badge bg-primary">Aktif</span>
                                @elseif ($data->status == 'N')
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        @if ($data->ktp)
                            <div class="mt-3 text-center">
                                <img src="{{ Storage::url($data->ktp) }}" alt="KTP" width="350">
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Apakah anda yakin menghapus data Karyawan ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Jika anda yakin ingin menghapus data Karyawan <strong>{{ $data->nama }}</strong>, Tekan Oke!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('karyawan.destroy', $data->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Oke</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->
