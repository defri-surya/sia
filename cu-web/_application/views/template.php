<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php echo CONFIG_SITE['meta_head']; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- NO INDEX MESIN PENCARI-->
    <meta name="googlebot" content="noindex" />
    <meta name="googlebot" content="nofollow" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="googlebot-news" content="nosnippet" />
    <meta name="googlebot-news" content="nofollow" />
    <meta name="robots" content="noindex" />
    <meta name="robots" content="nofollow" />

    <?php
    $menu_title = template_echo('title');
    if (empty($menu_title)) :
        $menu_title = $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title . ' - ' : '';
    endif;
    ?>

    <title><?php echo $menu_title; ?>Administrator</title>

    <!-- Bootstrap -->
    <link href="<?php echo THEMES_BACKEND; ?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo THEMES_BACKEND; ?>/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo THEMES_BACKEND; ?>/css/nprogress.css" rel="stylesheet">
    <!--bootstrap-daterangepicker-->
    <link href="<?php echo THEMES_BACKEND; ?>/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?php echo THEMES_BACKEND; ?>/vendor/css/daterangepicker-bs3.css" />

    <!--bootstrap-jqgrid-->
    <link href="<?php echo THEMES_BACKEND; ?>/css/jquery-ui.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo THEMES_BACKEND; ?>/js/jquery.min.js"></script>
    <!-- jQuery UI-->
    <script src="<?php echo THEMES_BACKEND; ?>/js/jquery-ui.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/moment.min.js"></script>
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/daterangepicker.js"></script>
    <script src="<?php echo THEMES_BACKEND; ?>/js/validator.js"></script>
    <script type="text/javascript" src="<?php echo THEMES_BACKEND; ?>/js/jquery.slimscroll.min.js"></script>
    <!-- jQuery custom content scroller -->
    <link href="<?php echo THEMES_BACKEND; ?>/js/scrollbar/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo THEMES_BACKEND; ?>/js/select2/select2.full.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo THEMES_BACKEND; ?>/js/select2/select2.min.css" />

    <!-- flexigrid starts here -->
    <script type="text/javascript" src="<?php echo base_url(); ?>addons/flexigrid/js/flexigridx.js?v=1.0.2"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>addons/flexigrid/js/json2.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>addons/flexigrid/css/flexigrid.css?v=1.0.2" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>addons/flexigrid/button/style.css?v=1.0.0" />
    <!-- flexigrid ends here -->

    <!--key.js-->
    <script src="<?php echo THEMES_BACKEND; ?>/js/jquery.key.js"></script>

    <!-- Custom Theme Style -->
    <link href="<?php echo THEMES_BACKEND; ?>/css/custom.css?v=1.0.3" rel="stylesheet">

    <?php
    if (isset($extra_head_content)) {
        echo $extra_head_content;
    }
    ?>

    <style>
        /* Absolute Center Spinner */
        .custom-loading {
            position: fixed;
            z-index: 999;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.3);
        }

        .custom-loading span {
            content: url(<?php echo THEMES_BACKEND . '/images/loading.gif'; ?>);
            position: fixed;
            z-index: 9999;
            width: 80px;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        .tooltip-inner {
            white-space: pre;
            max-width: none;
            text-align: left;
        }
    </style>
</head>

<?php
//profile image
if (isset($_SESSION['administrator_image']) && !empty($_SESSION['administrator_image']) && file_exists(_dir_administrator . $_SESSION['administrator_image'])) {
    $profile_image = $_SESSION['administrator_image'];
} else {
    $profile_image = '_default.png';
}

$arr_menu = array();
if (isset($this->arr_menu)) {
    if (count($this->arr_menu) > 0) {
        foreach ($this->arr_menu as $row_menu) {
            $arr_menu[$row_menu->administrator_menu_par_id][$row_menu->administrator_menu_order_by] = $row_menu;
        }
    }
}

$generate_menu = '<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li>
                                    <a href="' . site_url('dashboard') . '">
                                        <i class="fa fa-home"></i>&nbsp;Dashboard
                                    </a>
                                </li>';

if (array_key_exists('0', $arr_menu)) {
    ksort($arr_menu[0]);
    foreach ($arr_menu[0] as $rootmenu_sort => $rootmenu_value) {
        $sub_menu = "";
        $generate_submenu = "";
        if (array_key_exists($rootmenu_value->administrator_menu_id, $arr_menu)) {
            $rootmenu_link = 'javascript:;';
            ksort($arr_menu[$rootmenu_value->administrator_menu_id]);
            foreach ($arr_menu[$rootmenu_value->administrator_menu_id] as $submenu_1_sort => $submenu_1_value) {
                $sub_sub_menu = "";
                $generate_sub_sub_menu = "";
                if (array_key_exists($submenu_1_value->administrator_menu_id, $arr_menu)) {
                    $submenu_1_link = 'javascript:;';
                    ksort($arr_menu[$submenu_1_value->administrator_menu_id]);
                    foreach ($arr_menu[$submenu_1_value->administrator_menu_id] as $submenu_2_sort => $submenu_2_value) {
                        if (empty($submenu_2_value->administrator_menu_link)) {
                            $submenu_2_link = 'javascript:;';
                        } else {
                            $submenu_2_link = base_url() . $submenu_2_value->administrator_menu_link;
                        }
                        $sub_sub_menu .= '<li title="' . $submenu_2_value->administrator_menu_description . '"><a href="' . $submenu_2_link . '"><i class="' . $submenu_2_value->administrator_menu_class . '"></i>&nbsp;' . $submenu_2_value->administrator_menu_title . '</a></li>';
                    }
                } else {
                    if (empty($submenu_1_value->administrator_menu_link)) {
                        $submenu_1_link = 'javascript:;';
                    } else {
                        $submenu_1_link = base_url() . $submenu_1_value->administrator_menu_link;
                    }
                }
                if ($sub_sub_menu == '') {
                    $sub_menu .= '<li title="' . $submenu_1_value->administrator_menu_description . '"><a href="' . $submenu_1_link . '"><i class="' . $submenu_1_value->administrator_menu_class . '"></i>&nbsp;' . $submenu_1_value->administrator_menu_title . '</a></li>';
                } else {
                    $generate_sub_sub_menu = '<ul class="nav child_menu">' . $sub_sub_menu . '</ul>';

                    $sub_menu .= '<li title="' . $submenu_1_value->administrator_menu_description . '"><a href="' . $submenu_1_link . '"><i class="' . $submenu_1_value->administrator_menu_class . '"></i>&nbsp;' . $submenu_1_value->administrator_menu_title . ' <span class="fa fa-chevron-down"></span></a>';
                    $sub_menu .= $generate_sub_sub_menu;
                    $sub_menu .= '</li>';
                }
            }
        } else {
            if (empty($rootmenu_value->administrator_menu_link)) {
                $rootmenu_link = 'javascript:;';
            } else {
                $rootmenu_link = base_url() . $rootmenu_value->administrator_menu_link;
            }
        }
        if ($sub_menu == '') {
            $generate_menu .= '<li title="' . $rootmenu_value->administrator_menu_description . '"><a href="' . $rootmenu_link . '"><i class="' . $rootmenu_value->administrator_menu_class . '"></i>&nbsp;' . $rootmenu_value->administrator_menu_title . '</a></li>';
        } else {
            $generate_submenu = '<ul class="nav child_menu">' . $sub_menu . '</ul>';

            $generate_menu .= '<li title="' . $rootmenu_value->administrator_menu_description . '"><a href="' . $rootmenu_link . '"><i class="' . $rootmenu_value->administrator_menu_class . '"></i>&nbsp;' . $rootmenu_value->administrator_menu_title . ' <span class="fa fa-chevron-down"></span></a>';

            $generate_menu .= $generate_submenu;
            $generate_menu .= '</li>';
        }
    }
}
$generate_menu .= '<li>
                        <a href="' . base_url() . _logout_uri . '">
                            <i class="fa fa-sign-out"></i>&nbsp;Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>';
?>

<body class="nav-md footer_fixed">
    <div class="container body">
        <!--<div class="main_container" style="margin-bottom: 50px;">-->
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <!-- <a href="<?php echo site_url('dashboard'); ?>" class="site_title">
                            <?php
                            if (@file_exists('themes/backend/gentelella/images/' . CONFIG_SITE['logo_dashboard']['filename'])) {
                                echo '<img src="' . THEMES_BACKEND . '/images/'  . CONFIG_SITE['logo_dashboard']['filename'] . '" width="' . CONFIG_SITE['logo_dashboard']['width'] . '">';
                            } else {
                                echo '<i class="fa fa-paw"></i>';
                            }
                            ?>
                            <span style="font-size: 12pt"><?php echo CONFIG_SITE['site_title_dashboard']; ?></span>
                        </a> -->

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="<?php echo base_url() . 'media/' . _dir_administrator . '50/50/' . $profile_image; ?>" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span style="color: #ffcf3b;">Welcome,</span>
                                <h2><?php echo $_SESSION['administrator_name']; ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <?php echo $generate_menu; ?>
                    <!-- /sidebar menu -->

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-navicon"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo base_url() . 'media/' . _dir_administrator . '50/50/' . $profile_image; ?>" alt=""><?php echo $_SESSION['administrator_name']; ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a id="mProfile" href="<?php echo site_url('profile/systems/profile'); ?>"><i class="fa fa-user pull-right"></i> My Profile</a></li>
                                    <li><a href="<?php echo site_url('profile/systems/password'); ?>"><i class="fa fa-lock pull-right"></i> Change Password</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url(_logout_uri); ?>"><i class="fa fa-sign-out pull-right"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="right_col" role="main" style="min-height: 1054px;">
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-home"></i>&nbsp; Dashboard</a></li>
                    <?php
                    if ($this->index_menu !== '') {
                        $parent_index = array_search($this->arr_menu[$this->index_menu]->administrator_menu_par_id, array_column($this->arr_menu, 'administrator_menu_id'));
                        if ($parent_index !== FALSE) {
                            $arr_breadcrumbs = array(
                                $this->arr_menu[$parent_index]->administrator_menu_title => $this->arr_menu[$parent_index]->administrator_menu_link,
                                $this->arr_menu[$this->index_menu]->administrator_menu_title => $this->arr_menu[$this->index_menu]->administrator_menu_link
                            );
                        } else {
                            $arr_breadcrumbs = array(
                                $this->arr_menu[$this->index_menu]->administrator_menu_title => $this->arr_menu[$this->index_menu]->administrator_menu_link
                            );
                        }
                    }
                    if (isset($arr_breadcrumbs)) {
                        if (is_array($arr_breadcrumbs)) {
                            $i = 1;
                            foreach ($arr_breadcrumbs as $breadcrumbs_title => $breadcrumbs_links) {
                                if ($breadcrumbs_links != '#') {
                                    $breadcrumbs_links = base_url() . $breadcrumbs_links;
                                }
                                if ($i == count($arr_breadcrumbs)) {
                                    echo '<li class="active">' . $breadcrumbs_title . '</li>';
                                } else {
                                    echo '<li><a href="' . $breadcrumbs_links . '">' . $breadcrumbs_title . '</a></li>';
                                }
                                $i++;
                            }
                        }
                    }
                    ?>
                </ul>
                <!-- /top navigation -->
                <div id="mContent">
                    <?php
                    if (isset($_SESSION['confirmation'])) {
                        echo $_SESSION['confirmation'];
                    }
                    ?>
                    <?php echo template_echo('content'); ?>
                </div>
            </div>
            <!-- footer content -->
            <!--                <footer>
                    <div class="pull-right">
                        footer
                    </div>
                    <div class="clearfix"></div>
                </footer>-->
            <!-- /footer content -->
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?php echo THEMES_BACKEND; ?>/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo THEMES_BACKEND; ?>/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo THEMES_BACKEND; ?>/js/nprogress.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo THEMES_BACKEND; ?>/js/custom.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="<?php echo THEMES_BACKEND; ?>/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".custom-loading").hide();

            $('body').on('keyup', '.modal-footer button', function(e) {
                if (e.keyCode == 39) {
                    $(this).next().focus();
                }
                if (e.keyCode == 37) {
                    $(this).prev().focus();
                }
            });

            $('body').on('show.bs.modal shown.bs.modal', '.modal', function() {
                if ($(this).find('.my-modal-backdrop').length <= 0) {
                    $('<div class="in my-modal-backdrop"></div>').prependTo(this);
                }
                $('.modal-backdrop').remove();
            });

            $('body').on('shown.bs.modal', '.modal', function(e) {
                //                    $('form').find('input[type=text],textarea,select').filter(':visible:first').focus();
                let index = 1;
                let count = 0;
                let $element = $(this).find('[tabIndex=' + index + ']:visible');
                while (!$element.length && count <= 10) {
                    index++;
                    count++;
                    $element = $(this).find('[tabIndex=' + index + ']:visible');
                }
                if (!$element.length) {
                    $element = $(this).find('input[type=text],textarea,select').filter(':visible:first').focus();
                }
                $element.focus();
            });

            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
                let index = 1;
                let count = 0;
                let elemenId = $(this).attr('href');
                let $element = $(elemenId).find('[tabIndex=' + index + ']:visible');
                while (!$element.length && count <= 10) {
                    index++;
                    count++;
                    $element = $(elemenId).find('[tabIndex=' + index + ']:visible');
                }
                if (!$element.length) {
                    $element = $(elemenId).find('input[type=text],textarea,select').filter(':visible:first').focus();
                }
                $element.focus();
            });

            $('body').on('keypress', 'form input, form select', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    let count = 0;
                    let $element = $(this).closest('form');
                    let index = $(this).context.tabIndex + 1;
                    let $next = $element.find('[tabIndex=' + index + ']:visible');

                    //                        console.log($next.length);

                    while (!$next.length && count <= 10) {
                        index++;
                        count++;
                        $next = $element.find('[tabIndex=' + index + ']:visible');
                    }
                    //                        console.log($next);

                    if ($next.length) {
                        if ($next.hasClass('select2-selection')) {
                            let select2Id = $next.attr('aria-labelledby');
                            let selectId = select2Id.substring(8, select2Id.length - 10);
                            $('#' + selectId).select2('open');
                        } else {
                            $next.focus();
                        }
                    }
                }
            });

            $('body').on('select2:close', '.my-select2', function() {
                let count = 0;
                let $element = $(this).closest('form');
                let thisId = $(this).attr('id');

                let index = parseInt($('#select2-' + thisId + '-container').parent().attr('tabindex')) + 1;
                let $next = $element.find('[tabIndex=' + index + ']:visible');
                //            console.log($next.length);

                while (!$next.length && count <= 10) {
                    index++;
                    count++;
                    $next = $element.find('[tabIndex=' + index + ']:visible');
                }

                if ($next.hasClass('select2-selection')) {
                    let select2Id = $next.attr('aria-labelledby');
                    let selectId = select2Id.substring(8, select2Id.length - 10);
                    $('#' + selectId).select2('open');
                } else {
                    $next.focus();
                }
            });
        });

        $(document).ajaxComplete(function(event, XMLHttpRequest, ajaxOptions) {
            let ajaxResponseText = XMLHttpRequest.responseText;
            if (IsJsonString(ajaxResponseText)) {
                let res = JSON.parse(ajaxResponseText);
                if (res.status == 401) {
                    alert('Silahkan login ulang.');
                    window.location.href = '<?php echo site_url(_logout_uri); ?>';
                }
            } else {
                let arrResponse = ajaxResponseText.split('#');
                if (arrResponse[0] === 'expired') {
                    alert('Sesi Anda telah berakhir!');
                    window.location.href = '<?php echo site_url(_login_uri); ?>';
                }
                if (arrResponse[0] === 'Unauthorized') {
                    alert('Anda tidak diperkenankan mengakses fungsi tersebut!');
                }
            }
        });
        $(document).ajaxStart(function(event, XMLHttpRequest, ajaxOptions) {
            NProgress.start();
            $(".custom-loading").show();
        });

        $(document).ajaxStop(function(event, XMLHttpRequest, ajaxOptions) {
            NProgress.done();
            $(".custom-loading").hide();
        });

        function IsJsonString(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    </script>
</body>

</html>