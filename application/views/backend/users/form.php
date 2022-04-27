<form id="form" autocomplete="off">
    <div class="row form-view content-hide">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_logo') ?></h4>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_name') ?> <span class="wajib"></span></label>
                                <input type="text" id="Name" name="Name" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_email') ?> <span class="wajib"></span></label>
                                <input type="text" id="Email" name="Email" class="form-control">
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
                                <label class="control-label"><?= $this->lang->line('lb_start_join') ?> <span class="wajib"></span></label>
                                <input type="text" id="StartJoin" name="StartJoin" class="form-control mdate">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_address') ?> <span class="wajib"></span></label>
                                <input type="text" id="Address" name="Address" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_start_work_date') ?> <span class="wajib"></span></label>
                                <input type="text" id="StartWorkDate" name="StartWorkDate" class="form-control mdate">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_username') ?></label>
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_role') ?> <span class="wajib"></span></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_role('.Role')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Role-Name" placeholder="Select Role" readonly>
                                    <input type="hidden" id="Role" name="Role" class="Role"readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>


                    </div>
                    <?= $this->main->button('action') ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 content-hide">
            <div class="card">
                <div class="card-header bg-primary">
                    <span class="m-b-0 text-white"><?= $this->lang->line('lb_location') ?></span>
                    <div class="card-actions">
                        <a class="text-white" data-action="collapse"><i class="ti-minus"></i></a>
                    </div>
                </div>
                <div class="card-body show">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_location_name') ?> <span class="wajib"></span></label>
                                <input type="text" id="LocationName" name="LocationName" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_address') ?> <span class="wajib"></span></label>
                                <input type="text" id="Address" name="Address" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div> -->
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_latitude') ?> <span class="wajib"></span></label>
                                <input type="text" id="Latitude" name="Latitude" class="form-control" readonly placeholder="<?= $this->lang->line('lb_automatic') ?>">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_longitude') ?> <span class="wajib"></span></label>
                                <input type="text" id="Longidute" name="Longidute" class="form-control" readonly placeholder="<?= $this->lang->line('lb_automatic') ?>">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_radius') ?> (Meters) <span class="wajib"></span></label>
                                <input class="vertical-spin" type="text" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" value="0" name="Radius" id="Radius">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="MAPS" style="height: 500px;width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>