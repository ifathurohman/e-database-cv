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
    <title><?= "Verification User -".$this->lang->line('lb_app_name') ?></title>
    
    <!-- page css -->
    <link href="<?= base_url('asset/css/pages/login-register-lock.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('asset/css/style.min.css') ?>" rel="stylesheet">
</head>

<body class="skin-default card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"><?= $this->lang->line('lb_app_name') ?></p>
        </div>
    </div>
    <section id="wrapper" class="login-sidebar" style="background-image:url(<?= base_url('img/icon/bg-1.png') ?>);background-size: cover;">
    <div class="login-box" style="margin-right: 230px;">
        <div class="card-body" style="margin-top:22%;">
            <div class="form-group ">
                <div class="col-xs-12">
                    <h2 class="box-title m-t-40 m-b-0" style="font-weight:700">Activate User</h2>
                    <p style="font-size: 10pt; color:darkgray;margin-top: 15px;margin-bottom: 30px;">Please activate your account with the following button:</p>
                </div>
            </div>    
            <form id="form">
                <input type="hidden" name="ID" value="<?= $id ?>">
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-block btn-lg btn-info btn-verification btn-custom btn-rounded-cs" type="button">Activate user</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <img src="<?= base_url('img/icon/ciriajasa-1.png') ?>" alt="Home" style="padding:30px 0px 60px 90px"><br>
        <img id="img-for" src="<?= base_url('img/icon/forgot-password-1.png') ?>" alt="Home" style="margin: -20px 10px 115px 120px"><br>
        <span class="text-muted" style="margin-left: 100px;">© Ciriajasa Engineering & Management Consultant. Hak Cipta Dilindungi Undang-Undang</span>
        
    </section>
    <script src="<?= base_url('assets/node_modules/jquery/jquery-3.2.1.min.js') ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('assets/node_modules/popper/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <!-- Sweet Alert -->
    <link href="<?= base_url('assets/node_modules/sweetalert/sweetalert.css') ?>" rel="stylesheet" type="text/css">
    <script src="<?= base_url('assets/node_modules/sweetalert/sweetalert.min.js') ?>"></script>
    <!--Custom JS -->
    <script src="<?= base_url('asset/js/custom/verification.js').$this->main->version_js() ?>"></script> 
    
</body>

<style>
    .btn-custom {
        background: rgb(86,204,242);
        background: linear-gradient(60deg, rgba(86,204,242,1) 0%, rgba(47,128,237,1) 100%);
    }

    .input-custom{
        line-height: 3rem;
    }
</style>

</html>