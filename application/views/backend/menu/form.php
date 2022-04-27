<div class="row form-view content-hide">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 pg-title text-white"></h4>
            </div>
            <div class="card-body">
                <form id="form" autocomplete="off">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">
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
                                <label class="control-label"><?= $this->lang->line('lb_url') ?></label>
                                <input type="text" id="Url" name="Url" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_root') ?></label>
                                <input type="text" id="Root" name="Root" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_type') ?></label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="Type[]" value="backend" id="type_backend">
                                            <label class="custom-control-label pointer" for="type_backend"><?= $this->lang->line('lb_backend') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="Type[]" value="frontend" id="type_frontend">
                                            <label class="custom-control-label pointer" for="type_frontend"><?= $this->lang->line('lb_frontend') ?></label>
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
                                <label class="control-label"><?= $this->lang->line('lb_level') ?> <span class="wajib"></span></label>
                                <select name="Level" id="Level" class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6 Parent-view">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_parent') ?> <span class="wajib"></span></label>
                                <select class="form-control select2 menu_parent" style="width: 100%" name="Parent" id="Parent">
                                    <option value="0">Select Parent</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_role') ?></label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="Role" value="1" id="Role">
                                            <label class="custom-control-label" for="Role"><?= $this->lang->line('lb_active') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_icon') ?></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="open_modal_icon('Icon')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" id="Icon" name="Icon" class="form-control Icon" placeholder="Icon">
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                    </div>
                    <?= $this->main->button('action') ?>
                </form>
            </div>
        </div>
    </div>
</div>