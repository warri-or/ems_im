<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    $action_data["action_back"]=base_url($CI->controller_url);
    $action_data["action_save"]='#save_form';
    $action_data["action_clear"]='#save_form';
    $CI->load->view("action_buttons",$action_data);
?>
<?php
if(isset($message))
{
    ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php
}
if(isset($assigned_area['user_id']))
{
    ?>
    <div class="widget-header">
        <div class="title">
            Assigned Area
        </div>
        <div class="clearfix"></div>
    </div>

    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php if($assigned_area['division_name']){echo $assigned_area['division_name']; }else{echo 'All';};?></label>
        </div>
    </div>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php if($assigned_area['zone_name']){echo $assigned_area['zone_name']; }else{echo 'All';};?></label>
        </div>
    </div>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php if($assigned_area['territory_name']){echo $assigned_area['territory_name']; }else{echo 'All';};?></label>
        </div>
    </div>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php if($assigned_area['district_name']){echo $assigned_area['district_name']; }else{echo 'All';};?></label>
        </div>
    </div>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php if($assigned_area['upazilla_name']){echo $assigned_area['upazilla_name']; }else{echo 'All';};?></label>
        </div>
    </div>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UNION_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php if($assigned_area['union_name']){echo $assigned_area['union_name']; }else{echo 'All';};?></label>
        </div>
    </div>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_REMARKS');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php echo $assigned_area['remarks'];?></label>
        </div>
    </div>
<?php

}
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $user_info['user_id']; ?>" />
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0" />
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
                <select id="division_id" name="area[division_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($divisions as $division)
                    {?>
                        <option value="<?php echo $division['value']?>"><?php echo $division['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div style="display: none" class="row show-grid" id="zone_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="zone_id" name="area[zone_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                </select>
            </div>
        </div>
        <div style="display: none" class="row show-grid" id="territory_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="territory_id" name="area[territory_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                </select>
            </div>
        </div>
        <div style="display: none" class="row show-grid" id="district_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="district_id" name="area[district_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                </select>
            </div>
        </div>
        <div style="display: none" class="row show-grid" id="upazilla_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="upazilla_id" name="area[upazilla_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                </select>
            </div>
        </div>
        <div style="display: none" class="row show-grid" id="union_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UNION_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="union_id" name="area[union_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                </select>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_REMARKS');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <textarea class="form-control" id="remarks" name="area[remarks]"></textarea>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>
</form>
<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).on("change","#division_id",function()
        {
            $("#zone_id").val("");
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#union_id").val("");
            var division_id=$('#division_id').val();
            if(division_id>0)
            {
                $('#zone_id_container').show();
                $('#territory_id_container').hide();
                $('#district_id_container').hide();
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
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
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
            }
        });
        $(document).on("change","#zone_id",function()
        {
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#union_id").val("");
            var zone_id=$('#zone_id').val();
            if(zone_id>0)
            {
                $('#territory_id_container').show();
                $('#district_id_container').hide();
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
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
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
            }
        });
        $(document).on("change","#territory_id",function()
        {
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#union_id").val("");
            var territory_id=$('#territory_id').val();
            if(territory_id>0)
            {
                $('#district_id_container').show();
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_districts_by_territoryid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{territory_id:territory_id},
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
                $('#district_id_container').hide();
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
            }
        });
        $(document).on("change","#district_id",function()
        {
            $("#upazilla_id").val("");
            $("#union_id").val("");
            var district_id=$("#district_id").val();
            if(district_id>0)
            {
                $('#upazilla_id_container').show();
                $('#union_id_container').hide();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_upazillas_by_districtid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{district_id:district_id},
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
                $('#upazilla_id_container').hide();
                $('#union_id_container').hide();
            }
        });
        $(document).on("change","#upazilla_id",function()
        {
            $("#union_id").val("");
            var upazilla_id=$("#upazilla_id").val();
            if(upazilla_id>0)
            {
                $('#union_id_container').show();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_unions_by_upazillaid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{upazilla_id:upazilla_id},
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
                $('#union_id_container').hide();
            }
        });


    });
</script>
