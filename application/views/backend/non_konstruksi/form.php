<div class="card-form with-frame">

<?php $this->load->view($b_form); ?>

<form id="form" name="form-non-konstruksi" autocomplete="off" data-id = "<?= $id ?>">
    <div class="row form-view content-hide">
    <div class="col-md-12">
            <div class="card collapsed-card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="m-b-0 text-muted-bold">DAFTAR RIWAYAT HIDUP</h4>
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
                        <div class="col-md-8 order-2 order-md-1">
                            <div class="form-group">
                                <label class="custom-label">POSISI YANG DI USULKAN </label>
                                <input class="form-control total_pendidikan input-custom total_pendidikan Posisi" name="Posisi" type="text" onclick="modal_riwayat('.Posisi')" placeholder="Masukan nama posisi yang diusulkan">
                                <input type="text" id="Posisi" name="Posisi" class="Posisi content-hide" readonly>
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERUSAHAAN </label>
                                <input class="form-control input-custom" name="Nama_perusahaan1" type="text" placeholder="Masukan nama perusahaan" readonly="">
                                <!-- <small class="form-control-feedback"></small> -->
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERSONIL </label>
                                <input class="form-control input-custom" name="Nama_personil" type="text" placeholder="Masukan nama personil" readonly="">
                                <!-- <small class="form-control-feedback"></small> -->
                            </div>
                            <div class="form-group">
                                <label class="custom-label">TEMPAT & TANGGAL LAHIR</label>
                                <input class="form-control input-custom" name="Tempat_tanggal_lahir" type="text" placeholder="Masukan tempat & tanggal lahir" readonly="">
                                <!-- <small class="form-control-feedback"></small> -->
                            </div>
                            <div class="form-group">
                                <div class="inline-editor">
                                    <label class="custom-label-textarea">PENDIDIKAN</label>
                                        <textarea class="form-control summernote_pendidikan" name="Pendidikan" id="Pendidikan1"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="inline-editor">
                                    <label class="custom-label-textarea">PENDIDIKAN NON FORMAL </label>
                                        <textarea class="form-control summernote_pendidikan_non" name="Pendidikan_non_formal" id="Pendidikan_non_formal1"></textarea>
                                </div>
                            </div>
                            <div class="form-group ml-13-px">
                                <label class="custom-label-2">PENGUASAN BAHASA INDONESIA</label>
                                <div id="Penguasaan_bahasa_indo" class="row mobile-radio-groups radio-cols">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Penguasaan_bahasa_indo" id="cukup1" value="Cukup" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Cukup</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Penguasaan_bahasa_indo" id="baik1" value="Baik" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Baik</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Penguasaan_bahasa_indo" id="sangat_baik1" value="Sangat Baik" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Sangat Baik</label>
                                        </div>
                                    </fieldset>
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <div class="form-group ml-13-px">
                                <label class="custom-label-2">PENGUASAN BAHASA INGGRIS</label>
                                <div class="row mobile-radio-groups radio-cols">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Penguasaan_bahasa_inggris" id="cukup2" value="Cukup" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Cukup</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Penguasaan_bahasa_inggris" id="baik2" value="Baik" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Baik</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Penguasaan_bahasa_inggris" id="sangat_baik2" value="Sangat Baik" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Sangat Baik</label>
                                        </div>
                                    </fieldset>
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <div class="form-group ml-13-px">
                                <label class="custom-label-2">PENGUASAN BAHASA SETEMPAT</label>
                                <div class="row mobile-radio-groups radio-cols">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Penguasaan_bahasa_setempat" id="cukup3" value="Cukup" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Cukup</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Penguasaan_bahasa_setempat" id="baik3" value="Baik" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Baik</label>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Penguasaan_bahasa_setempat" id="sangat_baik3" value="Sangat Baik" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Sangat Baik</label>
                                        </div>
                                    </fieldset>
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-1 order-md-2">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4 class="m-b-0 text-muted-bold border-left-orange title-custom">CARA MENGISI FORM</h4>
                                    <P class="p-custom">Klik input field "Posisi yang Di Usulkan" kemudian pilih salah satu tenaga ahli, data akan terisi secara otomatis setelah itu isi "Penguasaan bahasa" dengan memilih salah satu dari 3 jenis penilaian.</P>
                                    <P class="p-custom">
                                        Klik input field "Nama Kegiatan" kemudian pilih salah satu nama kegiatan yang diinginkan,
                                        setelah itu klik input field "Posisi Penugasan" kemudian pilih salah satu posisi penugasan yang sesuai.
                                    </P>
                                    <P class="p-custom">
                                        Isi "Status kepegawain" melalui pilihan yang tersedia, bagian terakhir yaitu klik check box pernyataan terlampir.
                                        Kemudian pilih "Eksport ke Word" untuk fungsi simpan data dan eksort file word atau pilih "Simpan" untuk menyimpan data saja. <b>Ketika pilih simpan, data yang sudah diinput tidak akan bisa view data ketika dipilih di output CV</b>
                                    </P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card collapsed-card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-7">
                            <h4 class="m-b-0 text-muted-bold">PENGALAMAN KERJA</h4>
                        </div>
                        <div class="col-5">
                            <h4 class="m-b-0 pull-right">
                                <span class="pointer btn-card-collapse">
                                    <i class="ti-arrow-circle-up up" style="font-weight:bold;font-size: x-large;"></i>
                                    <i class="ti-arrow-circle-down down" style="font-weight:bold;font-size: x-large;"></i>
                                </span>
                            </h4>
                            <h4 class="m-b-0 pull-right">
                            <span class="pointer" onclick="add_pengalaman()"><i class="fa fa-plus-square-o fa-lg" style="font-weight:500;font-size: 32px;margin-right: 25px;"></i></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-card collapsed-target">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">
                    <input type="hidden" name="PengalamanID[]" id="PengalamanID1">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="custom-label">NAMA KEGIATAN </label>
                                <input class="form-control input-custom total_pengalaman i-Nama_kegiatan Nama_kegiatan[]" name="Nama_kegiatan[]" id="Nama_kegiatan1" data-pengalaman="active" type="text" onclick="modal_pengalaman('#Nama_kegiatan1')" placeholder="Masukan nama kegiatan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">LOKASI KEGIATAN </label>
                                <input class="form-control input-custom" name="Lokasi_kegiatan[]" id="Lokasi_kegiatan1" type="text" placeholder="Masukan lokasi kegiatan" readonly="">
                            </div>
                            <div class="form-group">
                                <label class="custom-label">PENGGUNA JASA </label>
                                <input class="form-control input-custom" name="Pengguna_jasa[]" id="Pengguna_jasa1" type="text" placeholder="Masukan pengguna jasa" readonly="">
                            </div>
                            <div class="form-group">
                                <label class="custom-label">NAMA PERUSAHAAN</label>
                                <input class="form-control input-custom" name="Nama_perusahaan[]" id="Nama_perusahaan1" type="text" placeholder="Masukan nama perusahaan" readonly="">
                            </div>
                            <div class="form-group">
                                <label class="custom-label">POSISI PENUGASAN</label>
                                <input class="form-control input-custom Posisi_penugasan[]" name="Posisi_penugasan[]" id="Posisi_penugasan1" type="text" onclick="modal_penugasan('#Posisi_penugasan1')" placeholder="Masukan posisi penugasan">
                                <small class="form-control-feedback"></small>
                            </div>
                            <div class="form-group">
                                <div class="inline-editor">
                                    <label class="custom-label-textarea">URAIAN TUGAS </label>
                                    <textarea class="form-control Uraian_tugas" name="Uraian_tugas[]" id="Uraian_tugas1" placeholder="Masukan uraian tugas" readonly=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-label">WAKTU PELAKSANAAN</label>
                                <input class="form-control input-custom" name="Waktu_pelaksanaan[]" id="Waktu_pelaksanaan1" type="text" placeholder="Masukan waktu penugasan" readonly="">
                            </div>
                            <div class="form-group">
                                <label class="custom-label-2">STATUS KEPEGAWAIAN PADA PERUSAHAAN</label>
                                <div class="row mobile-radio-groups radio-cols">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Status_kepegawaian[]" id="status_kepeg1_tidak_tetap1" value="Tidak Tetap" class="form-check-input Status_kepegawaian1 radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tidak Tetap</label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Status_kepegawaian[]" id="status_kepeg1_tetap1" value="Tetap" class="form-check-input Status_kepegawaian1 radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tetap</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-label mb-4">SURAT REFERENSI DARI PENGGUNA JASA</label>
                                <input class="form-control input-custom mobile-pt-50" name="Surat_referensi[]" id="Surat_referensi1" type="text" placeholder="Masukan surat referensi dari pengguna jasa" value="Terlampir" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pengalaman_kerja"></div>


            <div class="card collapsed-card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="m-b-0 text-muted-bold">STATUS KEPEGAWAIAN</h4>
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
                                <label class="custom-label-2">STATUS KEPEGAWAIAN PADA PERUSAHAAN INI</label>
                                <div class="row mobile-radio-groups radio-cols">
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="Status_kepegawaian2" id="status_kepeg2_tidak_tetap" value="Tidak Tetap" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tidak Tetap</label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="controls">
                                        <div class="custom-control custom-radio ml-70-px">
                                            <input type="radio" name="Status_kepegawaian2" id="status_kepeg2_tetap" value="Tetap" class="form-check-input radio-custom">
                                            <label class="form-check-label label-custom1" style="margin-left:25px;">Tetap</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card collapsed-card">
                <div class="card-header bt-light-grey">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="m-b-0 text-muted-bold">PERNYATAAN</h4>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <P class="fw-500">Saya yang bertandatangan di bawah ini, menyatakan dengan sebenar-benarnya bahwa:<br>
                                <br>
                                a.	Daftar riwayat hidup ini sesuai dengan kualifikasi dan pengalaman saya;<br>
                                b.	Saya akan melaksanakan penugasan sesuai dengan waktu yang telah dijadwalkan dalam proposal   penawaran, kecuali terdapat permasalahan kesehatan yang mengakibatkan saya tidak bisa melaksanakan tugas;<br>
                                c.	Saya berjanji melaksanakan semua penugasan;<br>
                                d.	Saya bukan merupakan bagian dari tim yang menyusun Kerangka Acuan Kerja;<br>
                                e.	Saya akan memenuhi semua ketentuan Klausul 4 dan 5 pada IKP.<br>
                                <br>
                                Jika terdapat pengungkapan keterangan yang tidak benar secara sengaja atau sepatutnya diduga maka saya siap untuk digugurkan dari proses seleksi atau dikeluarkan jika sudah dipekerjakan.
                                </P>
                            </div>
                            <div class="form-group">
                                <div class="controls">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" class="form-check-input" name="Pernyataan" id="Pernyataan" style="width: 20px;height: 20px;">
                                        <label class="form-check-label label-custom1" style="margin-left:25px;">Saya Setuju</label>
                                    </div>
                                <div class="help-block"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="button-group action-buttons">
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-ekspor" onclick="export_data_word()">EKSPOR KE WORD</button>
                        <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save()">SIMPAN</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>

<script>
    autosize();
    function autosize(){
        var text = $('.autosize');

        text.each(function(){
            $(this).attr('rows',1);
            resize($(this));
        });

        text.on('input', function(){
            resize($(this));
        });
        
        function resize ($text) {
            $text.css('height', 'auto');
            $text.css('height', 'auto');
        }
    }
    $(".Uraian_tugas1").focus(function() {
        if(document.getElementById('Uraian_tugas1').value === ''){
            document.getElementById('Uraian_tugas1').value +='• ';
        }
    });
    $(".Uraian_tugas1").keyup(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            document.getElementById('Uraian_tugas1').value +='• ';
        }
        var txtval = document.getElementById('Uraian_tugas1').value;
        if(txtval.substr(txtval.length - 1) == '\n'){
            document.getElementById('Uraian_tugas1').value = txtval.substring(0,txtval.length - 1);
        }
    });
</script>

<style>
    .page-titles {
        background: #E6E9FB;
        padding: 14px;
        margin: 20px 0px 20px 0px;
        border-radius: 2px;
    }
    .autosize {
        resize: none;
        overflow: hidden;
    }
    .custom-label-textarea {
        margin-top: 25px;
        font-weight: 600;
        font-size: 15px;
    }
</style>