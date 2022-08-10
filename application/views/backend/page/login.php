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
    
    <!-- page css -->
    <link href="<?= base_url('asset/css/pages/login-register-lock.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:600,700,900" rel="stylesheet">
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
    <section id="wrapper" class="login-sidebar bg-background">
    <div class="login-box margin-right-230 mb-5">
        <div class='login-logo-custom-container d-md-none d-lg-none'>
            <img class="logo-custom logo" src="<?= base_url('img/icon/ciriajasa-1.png') ?>"><br>
        </div>
        <div class="card-body margin-top-17 plr-0-mobile">    
            <form class="text-center" id="loginform">
                <div class='d-md-none d-lg-none'>
                    <img class="header-img-mobile" src="<?= base_url('img/icon/output-onlinegiftools.gif') ?>">
                </div>
                <img width="250px" class='login-text-mobile' src="<?= base_url('img/icon/digital-E-Database-CV.png'); ?>"/><br>
                <img width="180px" class='login-text-2-mobile' style="margin-top:20px;" src="<?= base_url('img/icon/Login-to-continue.png'); ?>"/><br>
                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input class="form-control input-custom" name="username" type="text" placeholder="Nama">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <input class="form-control input-custom" name="password" type="password" placeholder="<?= $this->lang->line('lb_password') ?>">
                            <!-- <div class="input-group-append pointer show_password">
                                <span class="input-group-text"><i class="btn-icon fa fa-eye"></i></span>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center forgot-pass-container">
                            <!-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                <label class="form-check-label" for="customCheck1">Remember me</label>
                            </div>  -->
                            <div class="ms-auto">
                                <a href="javascript:void(0)" id="to-recover" class="forgot text-custom-1 padding-left-215"></i> Forgot password</a> 
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-block btn-lg btn-info btn-save btn-custom btn-rounded-cs" type="button"><?= $title ?></button>
                    </div>
                </div>
                 <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-block btn-lg btn-success btn-save-demo btn-rounded-cs" type="button">Login Demo</button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
<!--                    <span class="text-custom-1 responsive">Not a member ?</span><a href="javascript:void(0)" id="to-register" class="text-custom-2"> Register Now</a> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center text-bold-gray">
                        <p class="myCopy center-align m-t-20 db">
                            <span>Or continue with</span>
                        </p>
                        <div class="social" style="margin-top: 30px;margin-bottom: 30px;">
                            <img width="35px" src="<?= base_url('img/icon/Group-2.png'); ?>"/>
                            <img width="35px" src="<?= base_url('img/icon/Group-4.png'); ?>"/>
                        </div>
                    </div>
                </div>
            </form>
            <form id="recoverform" class='mt-0-mobile' style="margin-top:45%;">
                <div class='d-md-none d-lg-none text-center'>
                    <img class="header-img-mobile" src="<?= base_url('img/icon/forgot-password-1.png') ?>">
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h2 class="box-title m-t-40 m-b-0 register-title-mobile" style="font-weight:700">Reset Passsword</h2>
                        <p class='register-subtitle-mobile' style="font-size: 10pt; color:darkgray;margin-top: 15px;margin-bottom: 30px;">Enter the email associated with your account and we'll send you an email with instructions to reset your password </p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <!-- <div class="input-group"> -->
                            <input class="form-control input-custom" name="Email" type="text" required="" placeholder="Email">
                            <!-- <div class="input-group-append"> -->
                                <img class="icon-custom" width="30px" height="25px" src="<?= base_url('img/icon/email-1.png'); ?>"/>
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-block btn-lg btn-info btn-save-recover btn-custom btn-rounded-cs" type="submit">Send Instructions</button>
                    </div>
                </div>
                <!-- <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p>Already have an account? <a href="<?= site_url() ?>" class="text-info m-l-5"><b>Sign In</b></a></p>
                    </div>
                </div> -->
            </form>
            <form id="registerform" class='mt-0-mobile' style="margin-top:-15%;">
                <div class='d-md-none d-lg-none text-center'>
                    <img class="header-img-mobile" src="<?= base_url('img/icon/illustration-regis-01.png') ?>">
                </div>
                <h1 class="box-title m-t-40 m-b-0 register-title-mobile text-center-mobile" style="font-weight:700">Sign Up</h1>
                <h4 class="register-subtitle-mobile text-center-mobile" style="font-size: large;font-weight: 100;color: darkgray;margin-top: 10px;margin-bottom: 20px;">Register to continue</h4>
                <div class="form-group m-t-20">
                    <div class="col-xs-12">
                        <input class="form-control input-custom" name="full_name" type="text" placeholder="Name">
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control input-custom" name="phone_number" type="text" placeholder="Phone Number">
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control input-custom" name="email" type="text" placeholder="Email">
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <div class="form-group password-view">
                    <div class="col-xs-12">
                        <!-- <input class="form-control input-custom" type="password" placeholder="Confirm Password"><i class="toggle-password fa fa-eye" style="margin-left:-4%;"></i> -->
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="password" aria-label="password" autocomplete="new-password">
                            <div class="input-group-append pointer show_password">
                                <span class="input-group-text"><i class="btn-icon fa fa-eye"></i></span>
                            </div>
                        </div>
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck1">
                            <label class="form-check-label" for="customCheck1">I agree to all <a href="javascript:void(0)">Terms</a></label> 
                        </div>  -->
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-lg w-100 waves-effect btn-save-register waves-light text-white btn-rounded-cs" type="submit">Sign Up</button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p class="login-now text-custom-1">Already register? <a href="<?= site_url() ?>" class="text-info m-l-5"><b class="text-custom-2">Login Now</b></a></p>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <div class='login-logo-custom-container d-none d-md-block d-lg-block d-xl-block'>
            <img class="logo-custom logo" src="<?= base_url('img/icon/ciriajasa-1.png') ?>"><br>
        </div>
        <img class="image1-custom" id="img-log" src="<?= base_url('img/icon/output-onlinegiftools.gif') ?>">
        <img class="image2-custom register-image" id="img-reg" src="<?= base_url('img/icon/illustration-regis-01.png') ?>">
        <img class="image3-custom reset-image" id="img-for" src="<?= base_url('img/icon/forgot-password-1.png') ?>">
        <div class='copyright-mt'>
            <span class="copyright text-bold-gray margin-left-100px">© Ciriajasa Engineering & Management Consultant. Hak Cipta Dilindungi Undang-Undang</span>
        </div>
        
    </section>
    <script src="<?= base_url('assets/node_modules/jquery/jquery-3.2.1.min.js') ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('assets/node_modules/popper/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <!-- Sweet Alert -->
    <link href="<?= base_url('assets/node_modules/sweetalert/sweetalert.css') ?>" rel="stylesheet" type="text/css">
    <script src="<?= base_url('assets/node_modules/sweetalert/sweetalert.min.js') ?>"></script>
    <!--Custom JS -->
    <script src="<?= base_url('asset/js/custom/login.js').$this->main->version_js() ?>"></script> 

    <script src="https://use.fontawesome.com/71ca0c4bb1.js"></script>
    
</body>

<style>
    .copyright-mt{
        margin-top: 3rem;
    }
    .btn-custom {
        background: rgb(86,204,242);
        background: linear-gradient(60deg, rgba(86,204,242,1) 0%, rgba(47,128,237,1) 100%);
    }
    .input-custom{
        line-height: 3rem;
    }
    ::placeholder {
        color: lightgray !important;
        font-size: 18px;
        /* font-weight:100; */
    }
    .myCopy {
        display: block;
        height: 10px;
        border-bottom: solid 1px #d4d4d4;
        text-align: center;
    }
    .myCopy span {
        display: inline-block;
        background-color: #f0f4f7;
        padding: 0 10px;
    }
    .font-weight-700 {
        font-weight: 700;
    }
    .bg-background {
        background-image:url('img/icon/bg-1.png');
        background-size: cover;
    }
    .text-bold-gray {
        color: #949494 !important;
        font-size: 16px;
        font-weight: 100;
    }
    .margin-left-100px {
        margin-left: 100px;
    }
    .margin-right-230 {
        margin-right: 230px;
    }

    .margin-top-17 {
        margin-top:13%;
    }

    .logo-custom {
        padding:30px 0px 60px 90px;
    }

    .image1-custom {
        margin: -5px 10px 0px 168px;
        width: 35%;
    }

    .image2-custom {
        margin: -20px 10px 88px 225px;
    }

    .image3-custom {
        margin: -20px 10px 115px 195px;
    }

    .padding-left-215 {
        padding-left: 215px;
    }

    .text-custom-1 {
        font-size: 18px;
        font-weight: 700;
        color: black !important;
    }

    .text-custom-2 {
        font-size: 18px;
        font-weight: 700;
        color: #2F80ED !important;
    }

    .icon-custom {
        position: absolute;
        margin: 25px 0px 0px -50px;
    }

    @media only screen and (max-width: 700px) {
        .image1-custom {
            margin: -5px 10px 0px 168px !important;
            width: 35% !important;
            display:none;
        }
        .text-bold-gray {
            display: inline-block;
            text-align: center;
            padding: 5% !important;
        }
        .margin-left-100px {
            margin-left: 0px !important;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }
        .text-custom-1 {
            font-size: 18px;
            font-weight: 700;
            color: black !important;
            /*margin-left: 120px !important;*/
        }
        .responsive {
            margin-left: 10px !important;
        }
        .logo-custom {
            padding: 0px 0px 0px 0px;
        }
    }

    @media only screen and (max-width: 768px) {
        .text-center-mobile{
            text-align: center;
        }
        .register-title-mobile{
            margin-top: 0px !important;
            font-size: 25px;
        }
        .register-subtitle-mobile{
            font-size: 20px;
        }
        .mt-0-mobile{
            margin-top: 0px !important;
        }
        .plr-0-mobile{
            padding-left: 0px;
            padding-right: 0px;
        }
        .header-img-mobile{
            width: 200px;
            margin-bottom: 35px;
        }
        .login-text-mobile{
            width: 150px !important;
        }
        .login-text-2-mobile{
            width: 150px !important;
        }
        .copyright-mt{
            margin-top: 0px;
            background-color: #fff;
        }
        #recoverform{
            margin-top: 0px !important;
        }

        .margin-top-17 {
            margin-top: 0px !important;
        }
        
        .text-bold-gray {
            display: inline-block;
            text-align: center;
            padding: 5%;
        }
        .margin-left-100px {
            margin-left: 0px;
        }
        .text-custom-1 {
            font-size: 18px;
            font-weight: 700;
            color: black !important;
            margin-left: 120px;
        }
        .responsive {
            margin-left: 10px;
        }

        .login-logo-custom-container{
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .logo-custom {
            padding: 0px 0px 0px 0px;
            width: 100%;
            text-align: center;
        }

        .login-box {
            width: 80%;
            margin: 0 auto;
        }

        .margin-right-230 {
            margin-right: 10%;
        }

        .logo {
            margin-top: 0px !important;
            margin-left: 0px !important;
            margin-bottom: 5%;
        }

        .image1-custom, .image2-custom, .image3-custom {
            display:none !important;
        }

        .copyright{
            text-align: center;
            font-size: 12pt;
            margin-left: 5%;

        }

        .forgot{
            margin-left: 0px !important;
        }

        .forgot.padding-left-215{
            padding-left: 0px;
        }

        .forgot-pass-container{
            justify-content: flex-end !important;
        }
        

        .sweet-alert button{
            width: 150pt !important;
        }

        .login-sidebar{
            padding-bottom: 0px !important;
        }
    }

    @media only screen and (max-width: 1024px) {
        .text-bold-gray {
            display: inline-block;
            text-align: center;
            padding: 5%;
        }
        .margin-left-100px {
            margin-left: 0px;
        }
        .text-custom-1 {
            font-size: 18px;
            font-weight: 700;
            color: black !important;
            margin-left: 120px;
        }
        .responsive {
            margin-left: 10px;
        }
        .logo-custom {
            padding: 0px 0px 0px 0px;
        }

        .login-box {
            width: 80%;
            margin: 0 auto;
        }

        .margin-right-230 {
            margin-right: 10%;
        }

        .logo {
            margin-top:100%;
            margin-left:14%;
        }

        .image1-custom, .image2-custom, .image3-custom {
            display:none !important;
        }

        .login-now {
            margin-left: 5%;
        }

        .copyright{
            text-align: center;
            font-size: 12pt;
            margin-left: 5%;

        }

        .forgot{
            margin-left: 0px;
        }

        .forgot.padding-left-215{
            padding-left: 0px;
        }

        .forgot-pass-container{
            justify-content: flex-end !important;
        }
    }
    
</style>

</html>
