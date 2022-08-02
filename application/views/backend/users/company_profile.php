<!-- Bread crumb and right sidebar toggle -->
<div class="row page-titles page-data" data-url="<?= $url ?>" data-module="<?= $module ?>" data-lat="<?= $this->session->CompanyLatitude ?>" data-lng="<?= $this->session->CompanyLongitude ?>" data-radius="<?= $this->session->CompanyRadius ?>">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $title ?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= site_url($url) ?>"><?= $title ?></a></li>
            </ol>
            <!-- <?= $edit ?> -->
        </div>
    </div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<!-- Start Page Content -->
<div class="row list-view">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row el-element-overlay">
                    <div class="col-lg-3">
                        <div class="card">
                            <center>
                                <div class="el-card-item p-b-0">
                                    <div class="el-card-avatar el-overlay-1 img-profile"> 
                                        <img class="img-circle img-profile" src="<?= $this->session->CompanyImage ?>" alt="user"/>
                                        <div class="el-overlay">
                                            <ul class="el-info">
                                                <!-- <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?= $this->session->CompanyImage ?>"><i class="icon-magnifier"></i></a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title m-t-10"><?= $this->session->CompanyName ?></h4>
                                <div><hr class="mb-0"> </div>
                            </center>
                            <div class="card-body">
                                <small class="text-muted"><?= $this->lang->line('lb_email') ?></small>
                                <h6><?= $this->session->CompanyEmail ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_phone_number') ?></small>
                                <h6><?= $this->session->CompanyIso.$this->session->CompanyPhone ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_start_join') ?></small>
                                <h6><?= $this->session->CompanyJoinDate ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_start_work_date') ?></small>
                                <h6><?= $this->session->CompanyStartWorkDate ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_address') ?></small>
                                <h6><?= $this->session->CompanyAddress ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <!-- <div class="row">
                                    <?php
                                        $branch = $this->api->branch("company", $this->session->CompanyID);
                                        $no = -1;
                                        foreach ($branch as $k => $v) {
                                            $no += 1;

                                            if(!$v->Phone): $v->Phone = "-"; endif;

                                            $Color = $this->main->Color($no);
                                            $tg_data = ' data-no="'.$no.'" ';
                                            $tg_data .= ' data-name="'.$v->Name.'" ';
                                            $tg_data .= ' data-address="'.$v->Address.'" ';
                                            $tg_data .= ' data-radius="'.$v->Radius.'" ';
                                            $tg_data .= ' data-lat="'.$v->Latitude.'" ';
                                            $tg_data .= ' data-lng="'.$v->Longitude.'" ';
                                            $tg_data .= ' data-phone="'.$v->Phone.'" ';

                                            $item = '<div class="col-sm-6 box dt_branch" '.$tg_data.' >';
                                            $item .= '<div class="col-sm-12">
                                                <strong class="text-muted">'.$this->lang->line('lb_branch_name').'</strong>
                                                <h6> <i class="fa fa-map-marker txt-'.$Color.' txt-20"></i> '.$v->Name.'</h6>
                                            </div>';

                                            $item .= '<div class="col-sm-12">
                                                <strong class="text-muted">'.$this->lang->line('lb_phone_number').'</strong>
                                                <h6>'.$v->Phone.'</h6>
                                            </div>';

                                            $item .= '<div class="col-sm-12">
                                                <strong class="text-muted">'.$this->lang->line('lb_address').'</strong>
                                                <h6>'.$v->Address.'</h6>
                                            </div>';

                                            $item .= '</div>';

                                            echo $item;
                                        }
                                    ?>
                                    <div class="content-hide">
                                        <div class="col-sm-4">
                                            <strong class="text-muted"><?= $this->lang->line('lb_location_name') ?></strong>
                                            <h6><?= $this->session->CompanyLocation ?></h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong class="text-muted"><?= $this->lang->line('lb_address') ?></strong>
                                            <h6><?= $this->session->CompanyAddress ?></h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <strong class="text-muted"><?= $this->lang->line('lb_latitude') ?></strong>
                                            <h6><?= $this->session->CompanyLatitude ?></h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <strong class="text-muted"><?= $this->lang->line('lb_longitude') ?></strong>
                                            <h6><?= $this->session->CompanyLongitude ?></h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <strong class="text-muted"><?= $this->lang->line('lb_radius') ?></strong>
                                            <h6><?= $this->session->CompanyRadius." ".$this->lang->line('lb_meters') ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="MAPS" style="height: 300px;width: 100%"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- PLUGIN -->
<link href="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') ?>" rel="stylesheet">
<link href="<?= base_url('asset/css/pages/user-card.css') ?>" rel="stylesheet">

<!-- Plugins For This Page -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $this->config->item("maps_api"); ?>"></script>
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') ?>"></script>

<script src="<?= base_url('asset/js/custom/backend/company_profile.js') ?>"></script>