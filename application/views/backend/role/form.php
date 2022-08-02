<form id="form" autocomplete="off">
    <div class="row form-view content-hide">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 pg-title text-white"></h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_name') ?> <span class="wajib"></span></label>
                                <input type="text" id="Name" name="Name" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_remark') ?></label>
                                <textarea name="Remark" id="Remark" class="form-control"></textarea>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <?php
                        $HakAksesType   = $this->session->HakAksesType;
                        if(in_array($HakAksesType, array(1,2))): ?>
                        <div class="col-md-12 vtype">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_for') ?></label>
                                <select name="Type" id="Type" class="form-control">
                                    <?php
                                    if($HakAksesType == 1): echo '<option value="developer">Developer</option>'; endif;
                                    ?>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="company">Company</option>
                                </select>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php if($HakAksesType == 3 || !in_array($HakAksesType, array(1,2,3))): ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Level</label>
                                <select class="form-control" name="Level" id="Level">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                    <?= $this->main->button('action') ?>
                </div>
            </div>
        </div>

        <?php if($HakAksesType == 3 || !in_array($HakAksesType, array(1,2,3))): ?>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <span class="m-b-0 text-white"><?= $this->lang->line('lb_note') ?></span>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="card-title">Level</h4>
                        <ul class="list-icons">
                            <li class="m-0"><i class="ti-angle-right"></i> Top Level (CEO, COO, BOD)</li>
                            <li class="m-0"><i class="ti-angle-right"></i> Middle Top Level (Manager,SPV)</li>
                            <li class="m-0"><i class="ti-angle-right"></i> Staff Level</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <span class="m-b-0 text-white"><?= $this->lang->line('lb_role') ?></span>
                    <div class="card-actions">
                        <a class="text-white" data-action="collapse"><i class="ti-minus"></i></a>
                    </div>
                </div>
                <div class="card-body show">
                    <div class="vtabs customvtab">
                        <ul class="nav nav-tabs tabs-vertical ul-menu" role="tablist"></ul>
                        <div class="tab-content ul-menu-dt" style="width: 88%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
