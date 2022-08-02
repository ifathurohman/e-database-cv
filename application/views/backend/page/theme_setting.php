<?php
	$checked1 = '';
	$checked2 = '';
	$checked3 = '';

	${'checked'.$this->session->CompanyTheme} = ' checked ';
?>
<!-- Bread crumb and right sidebar toggle -->
<div class="row page-titles page-data" data-url="<?= $url ?>" data-module="<?= $module ?>">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $title ?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= site_url($url) ?>"><?= $title ?></a></li>
            </ol>
        </div>
    </div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="row list-view">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_list_data') ?></h4>
            </div>
            <div class="card-body">
                <?= $btn_add ?>
                <form id="form" autocomplete="off">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row el-element-overlay">
                                    <div class="col-sm-12">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="Theme" value="1" id="theme1" <?= $checked1 ?>>
                                            <label class="custom-control-label pointer" for="theme1"><?= $this->lang->line('lb_theme')." 1" ?></label>
                                        </div>
                                    </div>

                                    <?php foreach ($data->theme_1 as $k => $v) { ?>
                                    <div class="el-card-item p-b-0">
                                        <div class="el-card-avatar el-overlay-1 img-profile"> 
                                            <img src="<?= site_url($v) ?>" alt="user"/>
                                            <div class="el-overlay">
                                                <ul class="el-info">
                                                    <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?= site_url($v) ?>"><i class="icon-magnifier"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="col-sm-12 mt-10">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="Theme" value="2" id="theme2" <?= $checked2 ?>>
                                            <label class="custom-control-label pointer" for="theme2"><?= $this->lang->line('lb_theme')." 2" ?></label>
                                        </div>
                                    </div>
                                    <?php foreach ($data->theme_2 as $k => $v) { ?>
                                    <div class="el-card-item p-b-0">
                                        <div class="el-card-avatar el-overlay-1 img-profile"> 
                                            <img src="<?= site_url($v) ?>" alt="user"/>
                                            <div class="el-overlay">
                                                <ul class="el-info">
                                                    <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?= site_url($v) ?>"><i class="icon-magnifier"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="col-sm-12 mt-10">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="Theme" value="3" id="theme3" <?= $checked3 ?>>
                                            <label class="custom-control-label pointer" for="theme3"><?= $this->lang->line('lb_theme')." 3" ?></label>
                                        </div>
                                    </div>
                                    <?php foreach ($data->theme_3 as $k => $v) { ?>
                                    <div class="el-card-item p-b-0">
                                        <div class="el-card-avatar el-overlay-1 img-profile"> 
                                            <img src="<?= site_url($v) ?>" alt="user"/>
                                            <div class="el-overlay">
                                                <ul class="el-info">
                                                    <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?= site_url($v) ?>"><i class="icon-magnifier"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- PLUGIN -->
<link href="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') ?>" rel="stylesheet">
<link href="<?= base_url('asset/css/pages/user-card.css') ?>" rel="stylesheet">

<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') ?>"></script>

<script type="text/javascript">
    function save(p1){
        xform = '#form';
        $(xform+' .form-control-feedback').text('');
        $(xform+' .has-danger').removeClass('has-danger');
        $(xform+' .select2-has-danger').removeClass('select2-has-danger');
        proccess_save();

        add_data_page(xform);
        // ajax adding data to database
        var xform        = $(xform)[0]; // You need to use standard javascript object here
        var formData    = new FormData(xform);
        $.ajax({
            url : "<?= base_url('mobile-theme-setting-save') ?>",
            type: "POST",
            data: formData,
            dataType: "JSON",
            mimeType:"multipart/form-data", // upload
            contentType: false, // upload
            cache: false, // upload
            processData:false, //upload
            success: function(data)
            {
                show_console(data);
                if(data.status) //if success close modal and reload ajax table
                {   
                    swal('',data.message,'success');
                }
                else
                {
                    show_invalid_response(data);
                }
                end_save();
     
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                console.log(jqXHR.responseText);
                end_save();
            }
        });
    }
</script>