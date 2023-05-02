<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white"><strong>Data Pembayaran Ruko</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">Nama Penyewa</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->penyewa->nama }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Kode Ruko</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->ruko->kode }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Nominal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>@rupiah($data->nominal)
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Tanggal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">:
                                </strong>{{ date('d-m-Y', strtotime($data->created_at)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Status</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                @if ($data->status == 'baru')
                                    <span class="badge bg-primary">DP (Tanda Jadi)</span>
                                @elseif ($data->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif ($data->status == 'cicil')
                                    <span class="badge bg-info">Sebagian</span>
                                @elseif ($data->status == 'telat')
                                    <span class="badge bg-warning">Telat</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Keterangan</div>
                            <div class="col-lg-8 col-md-8"><strong class="text-primary">:
                                </strong>{{ $data->keterangan }}</div>
                        </div>

                        {{-- <div class="mt-3 text-center">
                            <img src="{{ Storage::url($data->ktp) }}" alt="KTP" width="350">
                        </div> --}}

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
