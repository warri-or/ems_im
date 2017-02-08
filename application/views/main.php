<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EMS</title>
        <link rel="shortcut icon"  type="image/x-icon" href="<?php echo base_url(); ?>images/logo.png">
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui/jquery-ui.theme.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/jqx/jqx.base.css">

    </head>
    <body>
        <script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>

        <!--    for jqx grid finish-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxcore.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxscrollbar.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.edit.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.sort.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.pager.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxbuttons.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxcheckbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxlistbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxmenu.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.filter.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.selection.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.columnsresize.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxdata.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxdatatable.js"></script>
        <!--    only for color picker-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxcolorpicker.js"></script>
        <!--    For column reorder-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.columnsreorder.js"></script>
        <!--    For print-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxdata.export.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.export.js"></script>
        <!--        for footer sum-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxgrid.aggregates.js"></script>
        <!-- for header tool tip-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxtooltip.js"></script>
        <!-- popup-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jqx/jqxwindow.js"></script>

        <!--    for jqx grid end-->
        <script type="text/javascript">
            var base_url = "<?php echo base_url(); ?>";
            var display_date_format = "dd-M-yy";
            var SELCET_ONE_ITEM = "<?php echo $CI->lang->line('SELECT_ONE_ITEM'); ?>";
            var DELETE_CONFIRM = "<?php echo $CI->lang->line('DELETE_CONFIRM'); ?>";
        </script>
        <header class="hidden-print">

            <img alt="Logo" height="40" class="site_logo pull-left" src="<?php echo base_url(); ?>images/logo.png">
            <div class="site_title pull-left">A.R. MALIK & Co. (PVT) LTD.</div>

        </header>

        <div class="container-fluid" style="margin-bottom: 40px;">
            <div id="system_menus">
                <?php
                $CI->load->view('menu');
                ?>
            </div>

            <div class="row dashboard-wrapper">
                <div class="col-sm-12" id="system_content">

                </div>
            </div>

        </div>
        <footer class="hidden-print navbar-fixed-bottom">
            <div>
                &copy; & All Rights Reserved by Sopan Seeds.
            </div>
            <div class="clearfix"></div>
        </footer>
        <div id="system_loading"><img src="<?php echo base_url(); ?>images/spinner.gif"></div>
        <div id="system_message"></div>
        <div id="popup_window">
            <div id="popup_window_title">Details</div>
            <div id="popup_content" style="overflow: auto;">
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/system_common.js"></script>
    </body>
</html>