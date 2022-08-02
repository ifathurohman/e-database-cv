<div id="modal-pengalaman" class="modal modal-primary fade modal-fade-in-scale-up in" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h4 class="modal-title" style="font-weight: bold">PENGALAMAN KERJA - NAMA KEGIATAN</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div> -->
      <div class="modal-body">
        <div class="row align-items-center">
            <div class='col-md-7'>
              <h4 class="modal-title" style="font-weight: bold"><span class='pengalaman-kerja-type'></span> - NAMA KEGIATAN</h4>
            </div>
            <div class='col-md-5'>
                <form id="form-filter-pengalaman" class='search-input'>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group mb-0">
                              <div class="input-group">
                                  <input type="text" name="f-Search" placeholder='Cari' class="form-control f-Search" onkeyup="modal_pengalaman_filter(event)" style="line-height: 2.5 !important;">
                                  <div class="input-group-append search-icon">
                                      <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                  </div>
                              </div>
                              <small class="form-control-feedback"></small>
                          </div>
                      </div>
                  </div>
                </form>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class='table-responsive'>
            <table id="table-modal-pengalaman" class="tablesaw table-bordered table-hover table-cursor table" style="width:100% !important">
              <thead>
                <tr>
                  <th>#</th>
                  <th>No</th>
                  <th>Nama Kegiatan</th>
                  <th>Waktu Pelaksanaan</th>
                </tr>
              </thead>
            </table>
            </div>
            <div id='table-modal-pengalaman-pagination' class='pagination-info-data'>
                <div class='display-info'>
                      
                </div>
                <div class='pagination'>
                    <button class='prev-btn'><i class='fa fa-arrow-left'></i></button>
                      <span class='curr-page'></span>
                      <button class='next-btn'><i class='fa fa-arrow-right'></i></button>
                   </div>
            </div>
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

<script src="<?= base_url('asset/js/custom/backend/kegiatan_modal.js').$this->main->version_js() ?>"></script>