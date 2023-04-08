<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white"><strong>{{ $data->nama }}</strong></h5>
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

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">NIK</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->nik }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">No. Telepon</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->telepon }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Nama Toko</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->toko }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Alamat</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->alamat }}
                            </div>
                        </div>
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
                            <div class="col-lg-4 col-md-4 label">Status</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                @if ($data->status == 'baru')
                                    <span class="badge bg-primary">Baru (DP)</span>
                                @elseif ($data->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif ($data->status == 'nunggak')
                                    <span class="badge bg-danger">Menunggak</span>
                                @elseif ($data->status == 'nonaktif')
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <img src="{{ Storage::url($data->ktp) }}" alt="KTP" width="350">
                        </div>

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
                <h5 class="modal-title text-white">Apakah anda yakin menghapus data Penyewa ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Jika anda yakin ingin menghapus data Penyewa <strong>{{ $data->nama }}</strong>, Tekan Oke!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('penyewa.destroy', $data->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Oke</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->
