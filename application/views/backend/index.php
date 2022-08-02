<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $this->main->LogoWebsite(); ?>">
    <title><?= $title."-".$this->lang->line('lb_app_name') ?></title>
    <!-- Custom CSS -->
    <?php $this->load->view('backend/maincss'); ?>
    <!-- End Custom CSS -->
    <!-- Jquery -->
    <?php $this->load->view('backend/mainjs'); ?>
    <!-- End Jquery -->
</head>

<body class="skin-default fixed-layout">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">E-DATABASE CV</p>
        </div>
    </div>
    <!-- Main wrapper - style you can find in pages.scss -->
    <div id="main-wrapper">
        <!-- Topbar header - style you can find in pages.scss -->
        <?php $this->load->view('backend/nav'); ?>
        <!-- End Topbar header -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <?php $this->load->view('backend/sidebar'); ?>
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Content -->
                <div class='main-content-wrapper'>
                    <?php $this->load->view($content); ?>
                </div>
                <!-- End Content -->
                <!-- Right sidebar -->
                <!-- .right-sidebar -->
                <?php $this->load->view('backend/setting'); ?>
                <!-- End Right sidebar -->
            </div>
            <!-- End Container fluid  -->
        </div>
        <!-- End Page wrapper  -->
        <!-- footer -->
        <footer class="footer text-center">
            <!-- COPYRIGHT © 2019 <a href="<?= site_url() ?>"><?= $this->lang->line('lb_app_name') ?></a> -->
            Copyright © 2021 - Ciriajasa Engineering & Management Consultant. Hak Cipta Dilindungi Undang-Undang (<span style='text-decoration: underline;'>V <?= substr($this->main->version_js(), strpos($this->main->version_js(), '=') + 1) ?></span>)
        </footer>
        <!-- End footer -->
    </div>
    <!-- End Wrapper -->
</body>

</html>