<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    $action_data["action_back"]=base_url($CI->controller_url);
    $action_data["action_save"]='#save_form';
    $action_data["action_save_new"]='#save_form';
    $action_data["action_clear"]='#save_form';
    $CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $upazilla['id']; ?>" />
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
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="division_id" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($divisions as $division)
                    {?>
                        <option value="<?php echo $division['value']?>" <?php if($division['value']==$upazilla['division_id']){ echo "selected";}?>><?php echo $division['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($upazilla['zone_id']>0)){echo 'display:none';} ?>" class="row show-grid" id="zone_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="zone_id" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($zones as $zone)
                    {?>
                        <option value="<?php echo $zone['value']?>" <?php if($zone['value']==$upazilla['zone_id']){ echo "selected";}?>><?php echo $zone['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div style="<?php if(!($upazilla['territory_id']>0)){echo 'display:none';} ?>" class="row show-grid" id="territory_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="territory_id" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($territories as $territory)
                    {?>
                        <option value="<?php echo $territory['value']?>" <?php if($territory['value']==$upazilla['territory_id']){ echo "selected";}?>><?php echo $territory['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div style="<?php if(!($upazilla['district_id']>0)){echo 'display:none';} ?>" class="row show-grid" id="district_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="district_id" name="upazilla[district_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($districts as $district)
                    {?>
                        <option value="<?php echo $district['value']?>" <?php if($district['value']==$upazilla['district_id']){ echo "selected";}?>><?php echo $district['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="upazilla[name]" id="name" class="form-control" value="<?php echo $upazilla['name'];?>"/>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ORDER');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="upazilla[ordering]" id="ordering" class="form-control" value="<?php echo $upazilla['ordering'] ?>" >
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
            var division_id=$('#division_id').val();
            if(division_id>0)
            {
                $('#zone_id_container').show();
                $('#territory_id_container').hide();
                $('#district_id_container').hide();
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
            }
        });
        $(document).on("change","#zone_id",function()
        {
            $("#territory_id").val("");
            $("#district_id").val("");
            var zone_id=$('#zone_id').val();
            if(zone_id>0)
            {
                $('#territory_id_container').show();
                $('#district_id_container').hide();
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
            }
        });
        $(document).on("change","#territory_id",function()
        {
            $("#district_id").val("");
            var territory_id=$('#territory_id').val();
            if(territory_id>0)
            {
                $('#district_id_container').show();
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
            }
        });

    });
</script>
