<div id="modal-role" class="modal modal-primary fade modal-fade-in-scale-up in" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= $this->lang->line('lb_role') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <table id="table-modal-role" class="tablesaw table-bordered table-hover table-cursor table full-width">
              <thead>
                <tr>
                  <th><?= $this->lang->line('lb_no') ?></th>
                  <th><?= $this->lang->line('lb_name') ?></th>
                  <th><?= $this->lang->line('lb_type') ?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <?= $this->main->button('close'); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('asset/js/custom/backend/role_modal.js').$this->main->version_js() ?>"></script>