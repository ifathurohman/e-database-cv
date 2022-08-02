<?php $this->load->view($b_form); ?>

<form id="form" autocomplete="off">
    <div class="row form-view content-hide">
    <div class="col-md-12">
            <div class="card" id="pengalaman_kerja">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="m-b-0 text-muted-bold">PENGALAMAN KERJA</h4>
                        </div>
                        <div class="col-md-6">
                            <h4 class="m-b-0 pull-right">
                            <span class="pointer"><i class="ti-arrow-circle-up" style="font-weight:bold;font-size: x-large;"></i></span>
                            </h4>
                            <!-- <h4 class="m-b-0 pull-right">
                            <span class="pointer" onclick="add_pengalaman()"><i class="fa fa-plus-square-o fa-lg" style="font-weight:500;font-size: 32px;margin-right: 25px;"></i></span>
                            </h4> -->
                        </div>
                    </div>
                </div>
                <div class="card-body bg-card">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">
                    <input type="hidden" name="PengalamanID" id="PengalamanID1">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="custom-label">NAMA KEGIATAN </label>
                                <input class="form-control input-custom Nama_kegiatan" name="Nama_kegiatan" id="Nama_kegiatan1" type="text" placeholder="Masukan nama kegiatan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">LOKASI KEGIATAN </label>
                                <input class="form-control input-custom" name="Lokasi_kegiatan" id="Lokasi_kegiatan1" type="text" placeholder="Masukan lokasi kegiatan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">PENGGUNA JASA </label>
                                <input class="form-control input-custom" name="Pengguna_jasa" id="Pengguna_jasa1" type="text" placeholder="Masukan pengguna jasa">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERUSAHAAN</label>
                                <input class="form-control input-custom" name="Nama_perusahaan" id="Nama_perusahaan1" type="text" placeholder="Masukan nama perusahaan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="custom-label-2">WAKTU PELAKSANAAN</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">MULAI</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Waktu_pelaksanaan_mulai" name="Waktu_pelaksanaan_mulai" value="<?= date("Y-m-01") ?>" class="form-control date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">SELESAI</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Waktu_pelaksanaan_selesai" name="Waktu_pelaksanaan_selesai" value="<?= date("Y-m-d") ?>" class="form-control date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-button">
                    <div class="card-body">
                        <div class="button-group">
                            <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                            <!-- <button type="button" class="btn waves-effect waves-light btn-custom btn-ekspor" onclick="export_data()">EKSPOR KE WORD</button> -->
                            <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save()">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="posisi_uraian" style="margin-top:2%;">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="m-b-0 text-muted-bold">POSISI DAN URAIAN TUGAS</h4>
                        </div>
                        <div class="col-md-6">
                            <h4 class="m-b-0 pull-right">
                            <span class="pointer"><i class="ti-arrow-circle-up" style="font-weight:bold;font-size: x-large;"></i></span>
                            </h4>
                            <h4 class="m-b-0 pull-right">
                            <span class="pointer" onclick="add_pengalaman()"><i class="fa fa-plus-square-o fa-lg" style="font-weight:500;font-size: 32px;margin-right: 25px;"></i></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-card">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">
                    <input type="hidden" name="PengalamanID" id="PengalamanID1">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="custom-label">POSISI PENUGASAN</label>
                                <input class="form-control input-custom Posisi_penugasan" name="Posisi_penugasan" id="Posisi_penugasan1" type="text" placeholder="Masukan posisi penugasan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <form method="post">
                                    <label class="custom-label-textarea">URAIAN TUGAS </label>
                                    <textarea class="Uraian_pengalaman" name="Uraian_pengalaman" id="Uraian_pengalaman1"></textarea>
                                </form>
                            </div>
                            <div class="boder" style="border: 2px dashed #000000;padding: 15px;">
                                <span style="font-size: larger; font-weight: bold;color: red;"> Contoh 3 Point Uraian Tugas :</span><br>
                                <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;">Sebagai penanggung jawab tertinggi pekerjaan manajemen konstruksi secara keceluruhan <span style="color:red; font-size:30px;">;</span> </span>
                                <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;">Sebagai koordinator seluruh kegiatan teknis maupun administrasi di lapangan <span style="color:red; font-size:30px;">;</span></span>
                                <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;">Sebagai pengkoordinir komunikasi antara PPK dengan penyedia jasa konstruksi <span style="color:red; font-size:30px;">.</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-button">
                    <div class="card-body">
                        <div class="button-group">
                            <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                            <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save_uraian()">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div id="posisi_uraian"></div> -->

        </div>
    </div>
</form>

<style>
    .page-titles {
        background: #E6E9FB;
        padding: 14px;
        margin: 20px 0px 20px 0px;
        border-radius: 2px;
    }
    .custom-label-textarea {
        margin-top: 25px;
        font-weight: 600;
        font-size: 15px;
    }
    .card-button {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #f7f7f7 !important;
        background-clip: border-box;
        border: 0 solid transparent;
        border-radius: 0;
    }
    .hint {
        font-size:0.8em;
        color:#800;
    }
</style>