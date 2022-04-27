<form id="form" autocomplete="off">
    <div class="row form-view">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_page_setting') ?></h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="crud">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <div class="form-group m-t-10">
                        <div class="form-group">
                            <label class="control-label"><?= $this->lang->line('lb_name') ?> <span class="wajib"></span></label>
                            <input type="text" id="Name" name="Name" class="form-control">
                            <small class="form-control-feedback"></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= $this->lang->line('lb_summary') ?> <span class="wajib"></span></label>
                            <input type="text" id="Summary" name="Summary" class="form-control">
                            <small class="form-control-feedback"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_description') ?></h4>
                </div>
               <div class="card-body">
                    <div class="inline-editor">
                        <textarea name="Description" class="form-control" placeholder="Description" style="display: none;"></textarea>
                        <small class="form-control-feedback"></small>
                    </div>
                    <?= $this->main->button('action2') ?>
                </div>
            </div>
        </div>
    </div>
</form>