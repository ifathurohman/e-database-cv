<?php $this->load->view($b_form); ?>

<form id="form" autocomplete="off">
    <div class="row form-view content-hide">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="m-b-0 text-muted-bold">DAFTAR BIODATA TENAGA AHLI</h4>
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
                                <label class="custom-label">POSISI YANG DIUSULKAN </label>
                                <input class="form-control input-custom" name="Posisi" type="text" placeholder="Posisi yang diusulkan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERSONIL </label>
                                <input class="form-control input-custom" name="Nama_personil" type="text" placeholder="Masukan nama personil">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERUSAHAAN </label>
                                <input class="form-control input-custom" name="Nama_perusahaan" type="text" placeholder="Masukan nama perusahaan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">TEMPAT TANGGAL LAHIR </label>
                                <input class="form-control input-custom" name="Tempat_tanggal_lahir" type="text" placeholder="Masukan tempat, tanggal lahir">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <div class="inline-editor">
                                    <label class="custom-label-textarea">PENDIDIKAN</label>
                                    <!-- <form method="post"> -->
                                        <textarea class="form-control summernote_pendidikan" name="Pendidikan" id="Pendidikan1"></textarea>
                                    <!-- </form> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="inline-editor">
                                    <label class="custom-label-textarea">PENDIDIKAN NON FORMAL </label>
                                    <!-- <form method="post"> -->
                                        <textarea class="form-control summernote_pendidikan_non" name="Pendidikan_non_formal" id="Pendidikan_non_formal1"></textarea>
                                    <!-- </form> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NO.HP</label>
                                <input class="form-control input-custom" name="Nomor_hp" id="Nomor_hp" type="text" placeholder="Masukan no.hp">
                            </div>
                            <div class="form-group">
                                <label class="custom-label">E-MAIL</label>
                                <input class="form-control input-custom" name="Email" type="text" placeholder="Masukan email">
                            </div>
                           
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4 class="m-b-0 text-muted-bold border-left-orange title-custom">CARA MENGISI FORM</h4>
                                    <P class="p-custom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis ullamcorper quis accumsan, ultrices eget. Eu, sed condimentum nibh sagittis at. Cursus nec, et dapibus sem pellentesque. Aliquam turpis orci tellus adipiscing sem.</P>
                                    <P class="p-custom">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis ullamcorper quis accumsan, </P>
                                    <P class="p-custom">ultrices eget. Eu, sed condimentum nibh sagittis at. Cursus nec, et dapibus sem pellentesque. Aliquam turpis orci tellus adipiscing sem. </P>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="button-group" style="margin-top:15%;">
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save()">SIMPAN</button>
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
    .custom-label-textarea {
        margin-top: 25px;
        font-weight: 600;
        font-size: 15px;
    }
</style>
