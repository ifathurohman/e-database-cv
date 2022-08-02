<form id="form-import" autocomplete="off">
    <input type="hidden" name="inputFileName" id="inputFileName">
    <input type="hidden" name="ID">
    <div class="row" style="margin-top: 5px;">
        <div class="col-12">
            <div class="card">
                <div class="card-header bt-light-grey">
                    <div class="row page-data list" data-url="<?= $url ?>" data-module="<?= $module ?>">
                        <div class="col-md-9 align-self-center">
                            <h4 class="m-b-0 text-muted-bold">UPLOAD FILE</h4>
                        </div>
                        <!-- <div class="col-md-3">
                            <img src="<?= base_url('img/icon/vscode-icons_file-type-excel.png')?>" width="25" style="margin-left: 30%;margin-top: -4px;">
                            <h5 class="card-title pull-right">Unduh Tamplate
                                <a href="<?= site_url('pengalaman-template') ?>" target="_blank">Disini</a>
                            </h5>
                        </div> -->
                    </div>
                </div>
                <div class="card-body bg-card">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="wrapper-header">
                            <!-- <div class="form-group inputDnD">
                                <input type="file" multiple="multiple" class="form-control-file text-success font-weight-bold" id="inputFile" onchange="readUrl(this)" data-title='Choose file in brwoser'>
                            </div> -->
                            <!-- <div class="progress-data"></div> -->
                                <form action="javascript::void(0)">
                                    <img src="<?= base_url('img/icon/google-docs_2.png')?>" width="90" style="margin-bottom: 15px;">
                                    <p>Drag your document, photos or videos</p>
                                    <p>here to start uploading</p>
                                    <p>OR</p>
                                    <div class="upload-btn-wrapper inputDnD">
                                        <button class="btn btn-browse">
                                            <i class="mdi mdi-plus-box" style="color: white;font-size: 15px;margin-right: 10px;"></i> 
                                            <span style="color: white;">Browse File</span>
                                        </button>
                                        <!-- <input class="custom-file-input file-input" type="file" id="file" name="file[]" multiple="multiple"> -->
                                        <input type="file" multiple="multiple" class="form-control-file text-success font-weight-bold" id="inputFile" onchange="readUrl(this)" data-title='Choose file in brwoser'>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- <div class="wrapper-detail">
                                <div class="row file_hide">
                                    <div class="col-lg-12">
                                        <h4 class="card-title"><i class="mdi mdi-cloud-upload" style="font-size: 100px;color: #99b9fc;"></i>File Not Found!</h4>
                                    </div>
                                </div>
                                <section class="progress-area"></section>
                                <section class="uploaded-area"></section>
                            </div> -->
                            <div class="file-result"></div>
                        </div>
                    </div>
                    <div class="card-button">
                        <div class="card-body">
                            <div class="button-group action-buttons">
                                <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>
                                <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save()">SIMPAN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- Files Upload -->
<link href="<?= base_url('assets/file_upload/pengalaman.css" rel="stylesheet') ?>">
<link href="<?= base_url('assets/file_upload/uraian.css" rel="stylesheet') ?>">
<!-- <script src="<?= base_url('assets/file_upload/upload_pengalaman.js') ?>"></script> -->

<style>
    .btn-custom{
        padding: 10px 50px 10px 50px;
    }
    .form-text{
        color: #000000;
        font-weight: 600;
        font-size: large;
    }
    .form-text1{
        color: #4660E8;
        font-weight: 600;
        font-size: large;
    }

    .id-form{
        color: #000000;
        font-weight: 500;
    }
    .card-footer, .card-header {
        padding: 1.75rem 1.25rem;
        background-color: rgb(255 255 255);
        border-bottom: 1px solid lightgrey;
    }
    .page-titles {
        background: #E6E9FB;
        padding: 14px;
        margin: 5px 0px 20px 0px;
        border-radius: 2px;
    }
    .margin-right{
        margin-right: 10%;
    }
    .btn-browse{
        background: rgb(69,90,228);
        background: linear-gradient(90deg, rgba(69,90,228,1) 0%, rgba(72,134,255,1) 100%);
    }
    .btn-save-custom{
        background: rgb(69,90,228);
        background: linear-gradient(90deg, rgba(69,90,228,1) 0%, rgba(72,134,255,1) 100%);
        color: #fff;
        font-size: 10px;
    }
    .btn-cancel-custom{
        background: rgb(255 255 255);
        color: #000;
        font-size: 10px;
        border: solid 1px;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .text-success{
        font-size: 20px;
	    font-weight: bold;
    }
    .text-danger{
        font-size: 20px;
	    font-weight: bold;
    }
    .text-info{
        font-size: 20px;
	    font-weight: bold;
    }
    /* .table th, .table thead th {
        font-weight: 500;
        min-width: 210px;
        text-align: center;
    } */
    .file-result .box-file-result{
        border-radius: 2px;
        border: 1px solid #E2E2E2;
        height: 70px;
        margin-top: 5px;
        background: rgb(233, 240, 255);
    }
    .file-result{
        max-height: 320px;
        overflow-y: scroll;
    }
    .file-result::-webkit-scrollbar{
        width: 0px;
    }
    a {
        color: #000000;
    }
    
</style>