<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();

?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/list');?>" method="post">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                if($CI->locations['division_id']>0)
                {
                    ?>
                    <label class="control-label"><?php echo $CI->locations['division_name'];?></label>
                    <input type="hidden" name="report[division_id]" value="<?php echo $CI->locations['division_id'];?>">
                <?php
                }
                else
                {
                    ?>
                    <select id="division_id" name="report[division_id]" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($divisions as $division)
                        {?>
                            <option value="<?php echo $division['value']?>"><?php echo $division['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                <?php
                }
                ?>
            </div>

        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_FISCAL_YEAR');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="fiscal_year_id" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($fiscal_years as $year)
                    {?>
                        <option value="<?php echo $year['value']?>"><?php echo $year['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_START');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" id="date_start" name="report[date_start]" class="form-control date_large" value="">
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_END');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" id="date_end" name="report[date_end]" class="form-control date_large" value="<?php echo System_helper::display_date(time());; ?>">
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">

            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="action_button pull-right">
                    <button id="button_action_report" type="button" class="btn" data-form="#save_form"><?php echo $CI->lang->line("ACTION_REPORT"); ?></button>
                </div>

            </div>
            <div class="col-xs-4">

            </div>
        </div>

    </div>

    <div class="clearfix"></div>
</form>
<div id="system_report_container">

</div>
<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).off("click", ".pop_up");


        $(document).on("click", ".pop_up", function(event)
        {

            var left=((($(window).width() - 550) / 2) +$(window).scrollLeft());
            var top=((($(window).height() - 550) / 2) +$(window).scrollTop());

            //$("#popup_window").jqxWindow({width: 630,height:550,position: { x: 60, y: 60  }});to change position always
            $("#popup_window").jqxWindow({position: { x: left, y: top  }});
            var row=$(this).attr('data-item-no');
            var row_info = $("#system_jqx_container").jqxGrid('getrowdata', row);
            $('#popup_content').html(row_info.details);
            $("#popup_window").jqxWindow('open');


        });

        $(".date_large").datepicker({dateFormat : display_date_format,changeMonth: true,changeYear: true,yearRange: "c-1:c+1"});
        $(document).on("change","#fiscal_year_id",function()
        {

            var fiscal_year_ranges=$('#fiscal_year_id').val();
            if(fiscal_year_ranges!='')
            {
                var dates = fiscal_year_ranges.split("/");
                $("#date_start").val(dates[0]);
                $("#date_end").val(dates[1]);

            }
        });

        $(document).on("change","#division_id",function()
        {
            $("#zone_id").val("");
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#customer_id").val("");
            var division_id=$('#division_id').val();
            if(division_id>0)
            {
                $('#zone_id_container').show();
                $('#territory_id_container').hide();
                $('#district_id_container').hide();
                $('#customer_id_container').hide();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_zones_by_divisionid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{division_id:division_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $('#zone_id_container').hide();
                $('#territory_id_container').hide();
                $('#district_id_container').hide();
                $('#customer_id_container').hide();
            }
        });
        $(document).on("change","#zone_id",function()
        {
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#customer_id").val("");
            var zone_id=$('#zone_id').val();
            if(zone_id>0)
            {
                $('#territory_id_container').show();
                $('#district_id_container').hide();
                $('#customer_id_container').hide();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_territories_by_zoneid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{zone_id:zone_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $('#territory_id_container').hide();
                $('#district_id_container').hide();
                $('#customer_id_container').hide();
            }
        });

    });
</script>
