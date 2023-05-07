<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $data->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Detail Inventaris <strong>{{ $data->kode }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">Kode Inventaris</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: {{ $data->kode }}</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">Nama Barang</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->nama }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Tanggal Pengadaan</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ date('d-m-Y', strtotime($data->tanggal)) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Harga Satuan</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>@rupiah($data->harga)
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label">Jumlah Barang</div>
                            <div class="col-lg-8 col-md-8">
                                <strong class="text-primary">: </strong>{{ $data->jumlah }}
                            </div>
                        </div>

                        @if ($data->keterangan)
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label">Keterangan</div>
                                <div class="col-lg-8 col-md-8">
                                    <strong class="text-primary">: </strong>{{ $data->keterangan }}
                                </div>
                            </div>
                        @endif
                        @if ($data->gambar)
                            <div class="mt-3 text-center">
                                <img src="{{ Storage::url($data->gambar) }}" width="350">
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
                <h5 class="modal-title text-white">Apakah anda yakin menghapus data Inventaris
                    <strong>{{ $data->kode }}</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Jika anda yakin ingin menghapus data Inventaris <strong>{{ $data->kode }}</strong>, Tekan Oke!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('inventaris.destroy', $data->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Oke</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->
