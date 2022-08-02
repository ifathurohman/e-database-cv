<div id="modal-icon" class="modal modal-primary fade modal-fade-in-scale-up in" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= $this->lang->line('lb_icon') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 pull-right">
              <div class="form-group">
                <div class="input-group">
                    <input type="text" placeholder="Search Icon" id="SearchIcon" class="form-control SearchIcon">
                    <div class="input-group-append pointer" onclick="clear_value('.SearchIcon','icon')">
                        <span class="input-group-text"><i class="btn-icon fa fa-times"></i></span>
                    </div>
                </div>
              </div>

          </div>
        </div>
        <div class="row fontawesome-icon-list dt-icon-list"></div>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <?= $this->main->button('close'); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('asset/js/custom/icon.js').$this->main->version_js() ?>"></script>