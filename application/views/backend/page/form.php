<?php $this->load->view($b_form); ?>

<form id="form-sdm-pt" autocomplete="off" style="margin-top:2%;">
    <div class="row form-view content-hide">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="m-b-0 text-muted-bold">DAFTAR SDM PEGAWAI PT CIRIAJASA EC</h4>
                        </div>
                        <div class="col-md-6">
                            <h4 class="m-b-0 pull-right">
                            <span class="pointer"><i class="ti-arrow-circle-up" style="font-weight:bold;"></i></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-card">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="custom-label">NAMA </label>
                                <input class="form-control input-custom Nama" name="Nama" type="text" placeholder="Masukan nama">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group ml-13-px">
                                <label class="custom-label-2">STATUS</label>
                                <div class="row">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Status_pegawai" id="tersedia" value="Tersedia" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tersedia</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Status_pegawai" id="tender" value="Tender" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tender</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Status_pegawai" id="terkontrak" value="Terkontrak" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Terkontrak</label>
                                        </div>
                                    </fieldset>                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERUSAHAAN </label>
                                <input class="form-control input-custom" name="Nama_perusahaan" type="text" placeholder="Masukan nama perusahaan" value="PT. Ciriajasa E.C." readonly="true">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">PROYEK</label>
                                <input class="form-control input-custom" name="Proyek" type="text" placeholder="Masukan proyek">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="custom-label-2">PERIODE PROYEK</label>
                                <!-- <input class="form-control input-custom" name="username" type="text" placeholder="Masukan tempat & tanggal lahir"> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">MULAI</label>
                                            <div class="input-group">
                                                <div class="input-group-append pointer">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Mulai" name="Peride_proyek_mulai" value="<?= date("Y-m-01") ?>" class="form-control date">
                                            </div>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">SELESAI</label>
                                            <div class="input-group">
                                                <div class="input-group-append pointer">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Selesai" name="Peride_proyek_selesai" value="<?= date("Y-m-d") ?>" class="form-control date">
                                            </div>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4 class="m-b-0 text-muted-bold border-left-orange title-custom">CARA MENGISI FORM</h4>
                                    <P class="p-custom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis ullamcorper quis accumsan, ultrices eget. Eu, sed condimentum nibh sagittis at. Cursus nec, et dapibus sem pellentesque. Aliquam turpis orci tellus adipiscing sem.</P>
                                    <P class="p-custom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis ullamcorper quis accumsan, </P>
                                    <P class="p-custom">ultrices eget. Eu, sed condimentum nibh sagittis at. Cursus nec, et dapibus sem pellentesque. Aliquam turpis orci tellus adipiscing sem. </P>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button-group" style="margin-top:15%;">
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save_sdm()">SIMPAN</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</form>

<form id="form-sdm-non" autocomplete="off">
    <div class="row form-view content-hide">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="m-b-0 text-muted-bold">DAFTAR SDM PEGAWAI NON PT CIRIAJASA EC</h4>
                        </div>
                        <div class="col-md-6">
                            <h4 class="m-b-0 pull-right">
                            <span class="pointer"><i class="ti-arrow-circle-up" style="font-weight:bold;"></i></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-card">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="custom-label">NAMA </label>
                                <input class="form-control input-custom Nama" name="Nama" type="text" placeholder="Masukan nama" >
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group ml-13-px">
                                <label class="custom-label-2">STATUS</label>
                                <div class="row">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Status_pegawai" id="tersedia1" value="Tersedia" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tersedia</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Status_pegawai" id="terkontrak1" value="Terkontrak" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Terkontrak</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERUSAHAAN </label>
                                <input class="form-control input-custom" name="Nama_perusahaan" type="text" placeholder="Masukan nama perusahaan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">PROYEK</label>
                                <input class="form-control input-custom" name="Proyek" type="text" placeholder="Masukan proyek">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="custom-label-2">PERIODE PROYEK</label>
                                <!-- <input class="form-control input-custom" name="username" type="text" placeholder="Masukan tempat & tanggal lahir"> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">MULAI</label>
                                            <div class="input-group">
                                                <div class="input-group-append pointer">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Mulai" name="Peride_proyek_mulai" value="<?= date("Y-m-01") ?>" class="form-control date">
                                            </div>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">SELESAI</label>
                                            <div class="input-group">
                                                <div class="input-group-append pointer">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-blank"></i></span>
                                                </div>
                                                <input type="text" id="Selesai" name="Peride_proyek_selesai" value="<?= date("Y-m-d") ?>" class="form-control date">
                                            </div>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4 class="m-b-0 text-muted-bold border-left-orange title-custom">CARA MENGISI FORM</h4>
                                    <P class="p-custom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis ullamcorper quis accumsan, ultrices eget. Eu, sed condimentum nibh sagittis at. Cursus nec, et dapibus sem pellentesque. Aliquam turpis orci tellus adipiscing sem.</P>
                                    <P class="p-custom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis ullamcorper quis accumsan, </P>
                                    <P class="p-custom">ultrices eget. Eu, sed condimentum nibh sagittis at. Cursus nec, et dapibus sem pellentesque. Aliquam turpis orci tellus adipiscing sem. </P>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button-group" style="margin-top:15%;">
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save_sdm_non()">SIMPAN</button>
                    </div>
                </div>
                
            </div>
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
</style>