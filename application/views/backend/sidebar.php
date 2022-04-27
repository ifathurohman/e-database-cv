<?php
    $HakAksesType   = $this->session->HakAksesType;
?>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
            <li class="nav-small-cap" style="margin-left: 8%; font-weight: bold;">MAIN MENU</li>
                <?php
                $menu_level_1 = $this->api->menu('level1_backend');
                foreach ($menu_level_1 as $k => $v):
                    $Icon  = ''; $Arrow = ''; $Link = 'javascript:;';
                    if($v->Url): $Link = site_url($v->Url); endif;
                    $parent_menu = $this->main->sidebar_menu_parent($v->ID);
                    if($parent_menu): $Arrow = ' has-arrow '; endif;
                    if($v->Icon): $Icon = '<i class="'.$v->Icon.'"></i>';endif;
                    if(strlen($parent_menu)>0):
                        echo
                        '<li class="uvp-list"> <a class="'.$Arrow.' waves-effect waves-dark" href="'.$Link.'" aria-expanded="false">'.$Icon.'<span class="hide-menu">'.$v->Name.'</span></a>
                            '.$parent_menu.'
                        </li>';
                    elseif($v->Url):
                        echo 
                        '<li> <a class="'.$Arrow.' waves-effect waves-dark" href="'.$Link.'" aria-expanded="false">'.$Icon.'<span class="hide-menu">'.$v->Name.'</span></a>
                            '."".'
                        </li>';
                    endif;
                endforeach;
                ?>
                <!-- <li> <a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false"><i class="icon-speedometer"></i><span class="hide-menu">Dashboard <span class="badge badge-pill badge-cyan ml-auto">4</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="index.html">Minimal </a></li>
                        <li><a href="index2.html">Analytical</a></li>
                        <li><a href="index3.html">Demographical</a></li>
                        <li><a href="index4.html">Modern</a></li>
                    </ul>
                </li> -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<style>
    .sidebar-nav ul li i {
        color: #fec107;
        font-size: 10px;
        margin: 0px 10px 0px 0px;
    }
</style>