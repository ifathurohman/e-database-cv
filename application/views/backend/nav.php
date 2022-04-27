<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= site_url() ?>">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="<?= base_url('assets/images/logo1.png') ?>" alt="homepage" class="dark-logo v-SiteLogo" />
                    <!-- Light Logo icon -->
                    <!-- <img src="<?= base_url('assets/images/logo-light-icon.png') ?>" alt="homepage" class="light-logo v-SiteLogo" /> -->
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span>
                 <!-- dark Logo text -->
                 <img src="<?= base_url('assets/images/text.png') ?>" alt="homepage" class="dark-logo v-SiteText" />
                 <!-- Light Logo text -->
                 <!-- <img src="<?= base_url('assets/images/logo-light-text.png') ?>" class="light-logo v-SiteLogo" alt="homepage" /></span> </a> -->
                 </span> </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><img src="<?= base_url('img/icon/ci_menu-alt-03.svg');?>"></a> </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
            </ul>
           <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
            <!-- ============================================================== -->
            <!-- Comment -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= base_url('img/icon/bell.png') ?>" width="30" height="25">
                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                    <ul>
                        <li>
                            <div class="drop-title">Notifications</div>
                        </li>
                        <li>
                            <div class="message-center">
                                <!-- Message -->
                                <a href="javascript:void(0)">
                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                    <div class="mail-contnet">
                                        <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)">
                                    <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                    <div class="mail-contnet">
                                        <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)">
                                    <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                    <div class="mail-contnet">
                                        <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)">
                                    <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- ============================================================== -->
            <!-- End Comment -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: small;font-weight: 500;">
                    <img src="<?= $this->session->Image ?>" width="40" height="40" class="rounded-circle" style="margin-right: 10px;"><?= $this->session->Name ?><i class="caret-icon ti-angle-down" style="  font-weight: bold;margin-left: 10px;"></i></a>
                    <div class="dropdown-menu user-account-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?= site_url('dashboard') ?>" class="dropdown-item"><i class="ti-layout-grid2"></i> Dashboard</a>
                        <a class="dropdown-item" href="<?= site_url('company-profile') ?>" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                        <a class="dropdown-item" href="<?= site_url('main/logout') ?>" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script>
    $('.dropdown').on('show.bs.dropdown', function () {
        var length = parseInt($('.dropdown-menu').css('width'), 7) * -1;
        // $('.dropdown-menu').css('left', length);
    })
    $(document).ready(function () {
            $('.ti-angle-down').on('click', function () {
                if ($(this).hasClass('ti-angle-down')) {
                    $(this).removeClass('ti-angle-down').addClass('ti-angle-up');
                }else{
                    $(this).removeClass('ti-angle-up').addClass('ti-angle-down');
                }
            });
        });
</script>