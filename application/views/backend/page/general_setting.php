<div class="row page-title page-data" data-page_name="<?= $title; ?>" data-url="<?= $url; ?>" data-page="<?= $page ?>">
</div>
<div class="row-md-12 pt-25">
   <div class="div-table-list">
      <form enctype="multipart/form-data" method="post" id="<?= $page; ?>">
         <div class="col-md-12">
            <div class="card">
               <!-- Nav tabs -->
               <ul class="nav nav-tabs customtab" role="tablist">

                  <li class="nav-item"> 
                     <a class="nav-link general-nav-link" href="<?= site_url("page-settings/general"); ?>">
                     <span class="hidden-sm-up"><i class="fa fa-file""></i></span> 
                     <span class="hidden-xs-down">General</span></a> 
                  </li>
                  <li class="nav-item"> 
                     <a class="nav-link policy-page-setting-nav-link" href="<?= site_url("page-settings/policy-page-setting"); ?>">
                     <span class="hidden-sm-up"><i class="fa fa-file""></i></span> 
                     <span class="hidden-xs-down">Privacy Policy</span></a> 
                  </li>
                  <li class="nav-item"> 
                     <a class="nav-link term-and-condition-nav-link" href="<?= site_url("page-settings/term-and-condition"); ?>">
                     <span class="hidden-sm-up"><i class="fa fa-file""></i></span> 
                     <span class="hidden-xs-down">Term & Condition</span></a> 
                  </li>
               </ul>
            </div>

            <!-- Tabs panes -->
            <div class="tab-content">

                <?php if($page == "general"): ?>
                  <div class="tab-pane active" role="tabpanel">
                     <div class="card">
                         <div class="card-header">
                              <span>General</span>
                              <span class="btn-group pull-right">
                                 <a href="javascript:;" onclick="save_setting(this)" data-page="<?= $page ?>" class="btn btn-primary btn-sm btn-save">Save Setting</a>
                              </span>
                         </div>
                          <div class="card-body">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label class="control-label">Site Logo</label>
                                <input type="file" id="SiteLogo" name="SiteLogo" class="dropify file_type" accept="image/*" data-height="110" data-max-file-size="2M" data-allowed-file-extensions="png jpg">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label">App Version Name (for the minimum version used)</label>
                                  <input type="text" id="AppVersionName" name="AppVersionName" class="form-control">
                                  <small class="form-control-feedback"></small>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label">App Version Code (for the minimum version used)</label>
                                  <input type="text" id="AppVersionCode" name="AppVersionCode" class="form-control">
                                  <small class="form-control-feedback"></small>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label">App Download Link</label>
                                  <input type="text" id="AppDownloadLink" name="AppDownloadLink" class="form-control">
                                  <small class="form-control-feedback"></small>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label">App Review Link</label>
                                  <input type="text" id="AppReviewLink" name="AppReviewLink" class="form-control">
                                  <small class="form-control-feedback"></small>
                              </div>
                            </div>

                          </div>
                         <!-- <div class="card-footer text-muted">agsfdgasdfasdh</div> -->
                     </div> 
                  </div>
                <?php endif; ?>

                <?php if($page == "policy-page-setting"): ?>
                  <div class="tab-pane active" role="tabpanel">
                     <div class="card">
                         <div class="card-header">
                              <span>Description</span>
                              <span class="btn-group pull-right">
                                 <a href="javascript:;" onclick="save_setting(this)" data-page="<?= $page ?>" class="btn btn-primary btn-sm btn-save">Save Setting</a>
                              </span>
                         </div>
                         <div class="card-body">
                              <form method="post">
                                 <textarea id="summernote" name="Description" class="form-control summernote"></textarea>
                              </form>  
                         </div>
                         <!-- <div class="card-footer text-muted">agsfdgasdfasdh</div> -->
                     </div> 
                  </div>
                <?php endif; ?>

                <?php if($page == "term-and-condition"): ?>
                  <div class="tab-pane active" role="tabpanel">
                     <div class="card">
                         <div class="card-header">
                             <span>Description</span>
                              <span class="btn-group pull-right">
                                 <a href="javascript:;" onclick="save_setting(this)" data-page="<?= $page ?>" class="btn btn-primary btn-sm btn-save">Save Setting</a>
                              </span>
                         </div>
                         <div class="card-body">
                              <form class="group">  
                                 <textarea id="Description" name="Description" class="form-control summernote"></textarea>
                              </form> 
                         </div>
                         <!-- <div class="card-footer text-muted">agsfdgasdfasdh</div> -->
                     </div>
                  </div>
                <?php endif; ?>
            </div>
         </div>
      </form>
   </div>
</div>


<link href="<?= base_url('assets/node_modules/summernote/dist/summernote.css') ?>" rel="stylesheet"/>
<link href="<?= base_url('assets/node_modules/dropify/dist/css/dropify.min.css') ?>" rel="stylesheet"/>
<link href="<?= base_url('dist/css/style.min.css') ?>" rel="stylesheet"/>
<!-- End CSS -->

<!-- Start JS -->
<script src="<?= base_url('assets/node_modules/summernote/dist/summernote.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/node_modules/dropify/dist/js/dropify.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('asset/js/custom/backend/general_setting.js').$this->main->version_js() ?>"></script>   

<script>
    $('.summernote').summernote({
        height: 350, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });
    $('.inline-editor').summernote({
         airMode: true,
         placeholder: "typing something here..."

    });
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>
<!-- End JS -->


