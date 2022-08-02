<?php
    $HakAksesType   = $this->session->HakAksesType;
?>

<form id="form" autocomplete="off">
    <div class="row form-view content-hide">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_photo_profile') ?></h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <center class="m-t-30">
                        <img class="img-circle img-photo img-profile">
                    </center>
                    <div class="form-group m-t-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" data-id="img-photo" name="photo" id="photo" accept="image/*">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 pg-title text-white"></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php
                    if(in_array($HakAksesType, array(1,2))): ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_company') ?> <span class="wajib"></span></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_company('.Company')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Company-Name" placeholder="Select Company" readonly>
                                    <input type="text" id="Company" name="Company" class="Company content-hide"readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    <?php endif; ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_branch') ?> <span class="wajib"></span></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_branch('.Branch')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Branch-Name" placeholder="Select Branch" readonly> 
                                    <input type="text" id="Branch" name="Branch" class="Branch content-hide" data-company="active" readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_name_full') ?> <span class="wajib"></span></label>
                                <input type="text" id="Name" name="Name" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_name_nickname') ?></label>
                                <input type="text" id="NameLast" name="NameLast" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_nik') ?></label>
                                <input type="text" id="Nik" name="Nik" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_departement') ?> <span class="wajib"></span></label>
                                <input type="text" id="Departement" name="Departement" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_position') ?></label>
                                <input type="text" id="Position" name="Position" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_gender') ?> <span class="wajib"></span></label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="Gender" value="0" id="male" checked>
                                            <label class="custom-control-label pointer" for="male"><?= $this->lang->line('lb_male') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="Gender" value="1" id="female">
                                            <label class="custom-control-label pointer" for="female"><?= $this->lang->line('lb_female') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_email') ?> <span class="wajib"></span></label>
                                <input type="text" id="Email" name="Email" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_start_work_date') ?> <span class="wajib"></span></label>
                                <input type="text" id="WorkDate" name="WorkDate" class="form-control mdate">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_phone_number') ?> <span class="wajib"></span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <select class="form-control" name="PhoneCountry" id="PhoneCountry">
                                            <option>+62</option>
                                        </select>
                                    </div>
                                    <input type="text" name="Phone" id="Phone" placeholder="exp : 81xxxxxxx" class="form-control" aria-label="Text input with dropdown button">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_work_pattern') ?> <span class="wajib"></span></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_pattern('.Pattern')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Pattern-Name" placeholder="Select Work Pattern" readonly> 
                                    <input type="text" id="Pattern" name="Pattern" class="Pattern content-hide" data-company="active" readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_role') ?> <span class="wajib"></span></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_role('.Role')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Role-Name" placeholder="Select Role" readonly> 
                                    <input type="text" id="Role" name="Role" class="Role content-hide" data-company="active" readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_parent') ?></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_user_company('.Parent')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Parent-Name" placeholder="Select Parent" readonly> 
                                    <input type="text" id="Parent" name="Parent" class="Parent content-hide" data-company="active" data-user="active" data-role="active" data-role_class="Role" readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_username') ?> <span class="wajib"></span></label>
                                <input type="text" id="Username" name="Username" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6 Password-view">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_password') ?></label>
                                <div class="input-group">
                                    <input type="password" id="Password" name="Password" class="form-control" placeholder="Password" aria-label="Password" autocomplete="new-password">
                                    <div class="input-group-append pointer show_password">
                                        <span class="input-group-text"><i class="btn-icon fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="default_imei" value="1" id="default_imei_">
                                            <label class="custom-control-label pointer" for="default_imei_"><?= $this->lang->line('lb_mandatory_imei') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="Website" value="1" id="Website">
                                            <label class="custom-control-label pointer" for="Website"><?= $this->lang->line('lb_website') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <?= $this->main->button('action') ?>
                </div>
            </div>
        </div>
    </div>
</form>
