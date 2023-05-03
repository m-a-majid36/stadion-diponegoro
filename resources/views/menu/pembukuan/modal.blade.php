<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $pembukuan->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white"><strong>Detail Transaksi</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Jenis</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                @if ($pembukuan->jenis == 'D')
                                    <span class="badge bg-success">Debit</span>
                                @elseif ($pembukuan->jenis == 'K')
                                    <span class="badge bg-danger">Kredit</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Tanggal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>
                                {{ date('d-m-Y', strtotime($pembukuan->tgl_transaksi)) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Deskripsi</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $pembukuan->deskripsi }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Keterangan</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $pembukuan->keterangan }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Nominal</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>@rupiah($pembukuan->nominal)
                            </div>
                        </div>

                        @if ($pembukuan->gambar)
                            <div class="mt-3 text-center">
                                <img src="{{ Storage::url($pembukuan->gambar) }}" width="350">
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
