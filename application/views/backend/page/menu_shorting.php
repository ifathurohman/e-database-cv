<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
#sortable li span { position: absolute; margin-left: -1.3em; }
</style>
<!-- Bread crumb and right sidebar toggle -->
<!-- Bread crumb and right sidebar toggle -->
<div class="row page-titles page-data" data-url="<?= $url ?>" data-module="<?= $module ?>">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $title ?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= site_url($url) ?>"><?= $title ?></a></li>
            </ol>
        </div>
    </div>
</div>
<!-- End Bread crumb and right sidebar toggle -->
<!-- Start Page Content -->
<div class="row list-view">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_list_data') ?></h4>
            </div>
            <div class="card-body">
                <?= $btn_add ?>
                <form id="form" autocomplete="off">
                    <ul class="list-menu-content taskList ui-sortable" id="main-menu-notfix" style="min-height: 200px;">
                        <?php 
                        $menu_level_1 = $this->api->menu('level1_backend');
                        foreach ($menu_level_1 as $k => $v) {
                            $parent_menu = $this->api->menu('level2_backend', $v->ID);
                            $item  = '<li class="item mt-10 ui-sortable-handle" data-id="'.$v->ID.'">';
                            $item .= '<i class="fa fa-align-justify"></i> '.$v->Name;
                            $item .= '<input type="hidden" name="ID[]" value="'.$v->ID.'"/>';
                            if(count($parent_menu)>0):
                                $item .= '<hr>';
                                $item .= '<ul class="list-menu-content mt-10 main-menu-notfix2">';
                                foreach ($parent_menu as $k2 => $v2) {
                                    $item .= '<li class="item2 ui-sortable-handle menu-header-'.$v->ID.'"
                                    data-id="'.$v2->ID.'">'.$v2->Name;
                                    $item .= '<input type="hidden" name="ID[]" value="'.$v2->ID.'"/>';
                                    $item .= '</li>';
                                }
                                $item .= '</ul>';
                            endif;
                            $item .= '</li>';
                            echo $item;
                        } ?>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- Plugin -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>

<script src="<?= base_url('assets/node_modules/jquery/jquery-ui.js') ?>"></script>
<script src="<?= base_url('asset/js/custom/backend/menu_shorting.js'.$this->main->version_js()) ?>"></script>
<script>
  $( function() {
    $( "#main-menu-notfix" ).sortable();
    $( "#main-menu-notfix" ).disableSelection();
    $( ".main-menu-notfix2" ).sortable();
    $( ".main-menu-notfix2" ).disableSelection();
  } );
</script>