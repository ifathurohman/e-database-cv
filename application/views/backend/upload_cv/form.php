<?php $this->load->view($b_form); ?>

<form id="form" autocomplete="off">
    <div class="row form-view content-hide">
        <div class="col-md-12">
            <div class="card collapsed-card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="m-b-0 text-muted-bold">UPLOAD PROYEK PER KEGIATAN</h4>
                        </div>
                        <div class="col-3">
                            <h4 class="m-b-0 pull-right">
                                <span class="pointer btn-card-collapse">
                                    <i class="ti-arrow-circle-up up" style="font-weight:bold;font-size: x-large;"></i>
                                    <i class="ti-arrow-circle-down down" style="font-weight:bold;font-size: x-large;"></i>
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-card collapsed-target">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="custom-label">NAMA KEGIATAN</label>
                                <input class="form-control input-custom" name="Nama_kegiatan" type="text" placeholder="Masukan nama kegiatan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">PENGGUNA JASA</label>
                                <input class="form-control input-custom" name="Pengguna_jasa" type="text" placeholder="Masukan pengguna jasa">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="col-md-12 Tanggal_tender-view">
                                <label class="custom-label-2">TANGGAL TENDER</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-append pointer">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Selesai" name="Tanggal_tender" class="form-control date" placeholder="Masukan tanggal tender">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view($upload); ?>
</form>

