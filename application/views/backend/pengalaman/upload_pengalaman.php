<!-- Start Page Content -->
<div class="row" style="margin-top: 2%;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row page-data list" data-url="<?= $url ?>" data-module="<?= $module ?>">
                    <div class="col-md-9 align-self-center">
                        <h4 class="form-text v-list">UPLOAD DATABASE</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="wrapper">
                            <form id="form-uraian" action="#">
                                <input class="file-input" type="file" name="file" hidden>
                                <img src="<?= base_url('img/icon/vscode-icons_file-type-excel.png')?>" width="90" style="margin-bottom: 15px;">
                                <p>Drag your document, photos or videos</p>
                                <p>here to start uploading</p>
                                <p>OR</p>
                                <button type="button" class="btn waves-effect waves-light btn-browse"><i class="mdi mdi-plus-box" style="color: white;font-size: 15px;margin-right: 10px;"></i> <span style="color: white;">Browse File</span></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8" style="margin-left: 85px;">
                        <section class="progress-area">
                            <li class="row">
                                <div class="content upload">
                                    <header>Uploading</header>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="<?= base_url('img/icon/vscode-icons_file-type-excel.png')?>" width="55" style="margin-bottom: 10px;">
                                        </div>
                                        <div class="col-md-11">
                                            <div class="details">
                                                <span class="name" style="font-weight: bold;">Database.xls<span style="font-weight: 100;margin-left:20px">7.5mb</span></span>
                                                <span class="percent"><i class="mdi mdi-close-box-outline"></i></span>
                                            </div>
                                            <div class="progress-bar-custom">
                                                <div class="progress"></div>
                                            </div>
                                            <span class="details">
                                                <span>36% done</span>
                                                <span>90KB/sec</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </section>
                    </div>
                </div>
                <div class="button-group" style="margin: 2%;">
                    <button type="button" class="btn waves-effect waves-light btn-custom btn-save-custom">SAVE</button>
                    <button type="button" class="btn waves-effect waves-light btn-custom btn-cancel-custom">CANCEL</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- Files Upload -->
<link href="<?= base_url('assets/file_upload/style.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/file_upload/upload_uraian.js') ?>"></script>

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
    /* .card-footer, .card-header {
        padding: 1.75rem 1.25rem;
        background-color: rgb(255 255 255);
        border-bottom: 1px solid lightgrey;
    } */
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
</style>