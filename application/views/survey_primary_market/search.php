<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    $action_data["action_back"]=base_url($CI->controller_url);
    $action_data["action_save"]='#save_form';
    $action_data["action_save_new"]='#save_form';

    $CI->load->view("action_buttons",$action_data);
?>
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_YEAR');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $survey['year'];?></label>
                <input type="hidden" id="year" value="<?php echo $survey['year'];?>"/>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                if($survey['division_id']>0)
                {
                    $division_name='';
                    foreach($divisions as $division)
                    {
                        if($division['value']==$survey['division_id'])
                        {
                            $division_name=$division['text'];
                        }
                    }
                    ?>
                    <label class="control-label"><?php echo $division_name;;?></label>
                <?php
                }
                else
                {
                    ?>
                    <select id="division_id" class="form-control">
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

        <div style="<?php if(!(sizeof($zones)>0)){echo 'display:none';} ?>" class="row show-grid" id="zone_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                if($survey['zone_id']>0)
                {
                    $zone_name='';
                    foreach($zones as $zone)
                    {
                        if($zone['value']==$survey['zone_id'])
                        {
                            $zone_name=$zone['text'];
                        }
                    }
                    ?>
                    <label class="control-label"><?php echo $zone_name;;?></label>
                <?php
                }
                else
                {
                    ?>
                    <select id="zone_id" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($zones as $zone)
                        {?>
                            <option value="<?php echo $zone['value']?>"><?php echo $zone['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                <?php
                }
                ?>
            </div>
        </div>
        <div style="<?php if(!(sizeof($territories)>0)){echo 'display:none';} ?>" class="row show-grid" id="territory_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                if($survey['territory_id']>0)
                {
                    $territory_name='';
                    foreach($territories as $territory)
                    {
                        if($territory['value']==$survey['territory_id'])
                        {
                            $territory_name=$territory['text'];
                        }
                    }
                    ?>
                    <label class="control-label"><?php echo $territory_name;?></label>
                <?php
                }
                else
                {
                    ?>
                    <select id="territory_id" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($territories as $territory)
                        {?>
                            <option value="<?php echo $territory['value']?>"><?php echo $territory['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                <?php
                }
                ?>
            </div>
        </div>
        <div style="<?php if(!(sizeof($districts)>0)){echo 'display:none';} ?>" class="row show-grid" id="district_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                if($survey['district_id']>0)
                {
                    $district_name='';
                    foreach($districts as $district)
                    {
                        if($district['value']==$survey['district_id'])
                        {
                            $district_name=$district['text'];
                        }
                    }
                    ?>
                    <label class="control-label"><?php echo $district_name;?></label>
                <?php
                }
                else
                {
                    ?>
                    <select id="district_id" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($districts as $district)
                        {?>
                            <option value="<?php echo $district['value']?>"><?php echo $district['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                <?php
                }
                ?>
            </div>
        </div>
        <div style="<?php if(!(sizeof($upazillas)>0)){echo 'display:none';} ?>" class="row show-grid" id="upazilla_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                if($survey['upazilla_id']>0)
                {
                    $upazilla_name='';
                    foreach($upazillas as $upazilla)
                    {
                        if($upazilla['value']==$survey['upazilla_id'])
                        {
                            $upazilla_name=$upazilla['text'];
                        }
                    }
                    ?>
                    <label class="control-label"><?php echo $upazilla_name;?></label>
                    <input type="hidden" id="upazilla_id" value="<?php echo $survey['upazilla_id']; ?>">
                <?php
                }
                else
                {
                    ?>
                    <select id="upazilla_id" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($upazillas as $upazilla)
                        {?>
                            <option value="<?php echo $upazilla['value']?>"><?php echo $upazilla['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                <?php
                }
                ?>
            </div>
        </div>
        <div style="<?php if(!($survey['upazilla_id']>0)){echo 'display:none';} ?>" class="row show-grid" id="crop_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_NAME');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="crop_id" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($crops as $crop)
                    {?>
                        <option value="<?php echo $crop['value']?>"><?php echo $crop['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div style="display: none;" class="row show-grid" id="crop_type_id_container">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_TYPE');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="crop_type_id" name="variety[crop_type_id]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                </select>
            </div>
        </div>

    </div>

    <div id="system_report_container">

    </div>

    <div class="clearfix"></div>


<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".datepicker").datepicker({dateFormat : display_date_format});
        $(document).on("change","#division_id",function()
        {
            $('#system_report_container').html('');
            $("#zone_id").val("");
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#crop_id").val("");
            $("#crop_type_id").val("");
            $('#territory_id_container').hide();
            $('#district_id_container').hide();
            $('#upazilla_id_container').hide();
            $('#crop_id_container').hide();
            $('#crop_type_id_container').hide();
            var division_id=$('#division_id').val();
            if(division_id>0)
            {
                $('#zone_id_container').show();
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
            }
        });
        $(document).on("change","#zone_id",function()
        {
            $('#system_report_container').html('');
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#crop_id").val("");
            $("#crop_type_id").val("");
            $('#district_id_container').hide();
            $('#upazilla_id_container').hide();
            $('#crop_id_container').hide();
            $('#crop_type_id_container').hide();
            var zone_id=$('#zone_id').val();
            if(zone_id>0)
            {
                $('#territory_id_container').show();
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

            }
        });
        $(document).on("change","#territory_id",function()
        {
            $('#system_report_container').html('');
            $("#upazilla_id").val("");
            $("#crop_id").val("");
            $("#crop_type_id").val("");
            $('#upazilla_id_container').hide();
            $('#crop_id_container').hide();
            $('#crop_type_id_container').hide();
            var territory_id=$('#territory_id').val();
            if(territory_id>0)            {
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
        $(document).on("change","#district_id",function()
        {
            $('#system_report_container').html('');
            $("#upazilla_id").val("");
            $("#crop_id").val("");
            $("#crop_type_id").val("");
            $('#crop_id_container').hide();
            $('#crop_type_id_container').hide();
            var district_id=$("#district_id").val();
            if(district_id>0)
            {
                $('#upazilla_id_container').show();
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
            }

        });
        $(document).on("change","#upazilla_id",function()
        {
            $('#system_report_container').html('');
            $("#crop_id").val("");
            $("#crop_type_id").val("");
            $('#crop_type_id_container').hide();
            var upazilla_id=$("#upazilla_id").val();
            if(upazilla_id>0)
            {
                $('#crop_id_container').show();
            }
            else
            {
                $('#crop_id_container').hide();
            }
        });
        $(document).on("change","#crop_id",function()
        {
            $('#system_report_container').html('');
            $("#crop_type_id").val("");

            var crop_id=$('#crop_id').val();
            if(crop_id>0)
            {
                $('#crop_type_id_container').show();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_croptypes_by_cropid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{crop_id:crop_id},
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
                $('#crop_type_id_container').hide();
            }
        });
        $(document).on("change","#crop_type_id",function()
        {
            $('#system_report_container').html('');
            var crop_type_id=$('#crop_type_id').val();
            var upazilla_id=$("#upazilla_id").val();
            var year=$('#year').val();

            if(crop_type_id>0)
            {

                $.ajax({
                    url: "<?php echo site_url($CI->controller_url.'/index/get_survey')?>",
                    type: 'POST',
                    datatype: "JSON",
                    data:{year:year,crop_type_id:crop_type_id,upazilla_id:upazilla_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
        });

    });
</script>
