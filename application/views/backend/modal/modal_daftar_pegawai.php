<div id="modal-daftar-pegawai" class="modal modal-primary fade modal-fade-in-scale-up in" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
  <div class="modal-dialog modal-lg-custom ">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row col-lg-12">
          <div class="col-lg-9 align-self-center">
              <h4 class="modal-title" style="font-weight: bold">DAFTAR SDM PEGAWAI NON PT CIRIAJASA EC</h4>
          </div>
          <div class="col-lg-3 align-self-center text-right">
            <form id="form-filter-pengalaman" class='search-input'>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group mb-0">
                          <div class="input-group">
                              <input type="text" name="f-Search" placeholder='Cari' class="form-control f-Search" onkeyup="modal_daftar_pegawai_filter(event)" style="line-height: 2.5 !important;">
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
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <table id="table-modal-daftar-pegawai" class="table table-hover no-wrap" style="width:100%;">
              <thead style="background: #3c4195;color: white;">
                <tr>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">#</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">NO</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">STATUS</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA PERUSAHAAN</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">PROYEK</th>
                    <th colspan="2" style="horizontal-align : middle;text-align:center;">PERIODE PROYEK</th>
                </tr>
                <tr>
                    <th scope="col">MULAI</th>
                    <th scope="col">SELESAI</th>
                </tr>
              </thead>
              <tbody style="font-weight: bold"></tbody>
          </table>
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

<script src="<?= base_url('asset/js/custom/backend/daftar_pegawai_modal.js').$this->main->version_js() ?>"></script>


<style>
  .tr-warning {
      background-color: rgb(255 238 191);
      width: 100%;
      color: #000000;
  }
</style>

<script type="">
$(document).on('mouseenter', ".iffyTip", function () {
     var $this = $(this);
     if (this.offsetWidth < this.scrollWidth && !$this.attr('title')) {
         $this.tooltip({
             title: $this.text(),
             placement: "top"
         });
         $this.tooltip('show');
     }
 });
$('.hideText').css('width',$('.hideText').parent().width());
</script>