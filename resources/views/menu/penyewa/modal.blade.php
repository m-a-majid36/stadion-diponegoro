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
                            <div class="col-lg-4 col-md-4 label">Mulai Sewa</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ date('d-m-Y', strtotime($data->mulai)) }}
                            </div>
                        </div>
                        @if ($data->status == 'nonaktif')
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">Selesai Sewa</div>
                                <div class="col-lg-8 col-md-8">
                                    <strong class="text-primary">:
                                    </strong>
                                    @if ($data->selesai)
                                        {{ date('d-m-Y', strtotime($data->selesai)) }}
                                    @else
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Status</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                @if ($data->status == 'nonaktif')
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @elseif ($data->status == 'baru')
                                    @if (date('Y-m-d H:i:s') < $data->selesai)
                                        <span class="badge bg-info">Tanda Jadi</span>
                                    @elseif (date('Y-m-d H:i:s') > $data->selesai)
                                        <span class="badge bg-danger">Belum Bayar</span>
                                    @endif
                                @elseif ($data->status == 'cicil')
                                    @if (date('Y-m-d H:i:s') < $data->selesai)
                                        <span class="badge bg-warning">Sebagian</span>
                                    @elseif (date('Y-m-d H:i:s') > $data->selesai)
                                        <span class="badge bg-danger">Belum Bayar Sebagian</span>
                                    @endif
                                @else
                                    @if (date('Y-m-d H:i:s') < $data->selesai)
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif (date('Y-m-d H:i:s') > $data->selesai)
                                        <span class="badge bg-danger">Belum Bayar</span>
                                    @endif
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
