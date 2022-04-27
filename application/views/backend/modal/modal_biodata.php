<div id="modal-biodata" class="modal modal-primary fade modal-fade-in-scale-up in" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
  <div class="modal-dialog modal-lg-custom">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="font-weight: bold">BIODATA TENAGA AHLI</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <table id="table-modal-biodata" class="tablesaw table-bordered table-hover table-cursor table" style="width:100% !important">
              <thead>
                <tr>
                  <th>#</th>
                  <th>No</th>
                  <th>Nama Personil</th>
                  <th>Pendidikan</th>
                  <th>Pendidikan Non Formal</th>
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

<style>
    .modal-lg-custom {
		max-width: 1250px;
	}
</style>

<script src="<?= base_url('asset/js/custom/backend/biodata_modal.js').$this->main->version_js() ?>"></script>