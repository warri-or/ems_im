<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
if($CI->controller_url=='Tm_fd_bud_budget'){
$action_data["action_save_new"]='#save_form';
}
$CI->load->view("action_buttons",$action_data);
?>
<style>
    .tbdgt{
        border: none !important;
        background-color: rgb(250,250,250) !important;
        cursor: default !important;
        box-shadow: none !important;
        margin-top: -6px !important;
        font-weight: bold !important;
    }
    .arm_remarks{
        width: 300px;
    }
    .com_remarks{
        width: 300px;
    }
</style>

<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
<input type="hidden" id="id" name="id" value="<?php echo $item['id']; ?>" />
<input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0" />
<div class="row widget">
<div class="widget-header">
    <div class="title">
        <?php echo $title; ?>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DATE');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <input type="text" name="item[date]" id="date" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date']); ?>"/>
    </div>
</div>

<div style="" class="row show-grid" id="crop_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <select id="crop_id" class="form-control">
            <option value=""><?php echo $this->lang->line('SELECT');?></option>
            <?php
            foreach($crops as $crop)
            {?>
                <option value="<?php echo $crop['value']?>" <?php if($crop['value']==$item_info['crop_id']){ echo "selected";}?>><?php echo $crop['text'];?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

<div style="<?php if(!($item['id']>0)){echo 'display:none';} ?>" class="row show-grid" id="crop_type_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_TYPE');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <select id="crop_type_id" class="form-control">
            <option value=""><?php echo $this->lang->line('SELECT');?></option>
            <?php
                foreach($crop_types as $type)
                {?>
                    <option value="<?php echo $type['value']?>" <?php if($type['value']==$item_info['crop_type_id']){ echo "selected";}?>><?php echo $type['text'];?></option>
                <?php
                }
            ?>
        </select>
    </div>
</div>

<div style="<?php if(!($item['id']>0)){echo 'display:none';} ?>" class="row show-grid" id="variety_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_VARIETY_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <select id="variety_id" name="item_info[variety_id]" class="form-control">
            <option value=""><?php echo $this->lang->line('SELECT');?></option>
            <?php
            foreach($crop_varieties as $variety)
            {?>
                <option value="<?php echo $variety['value']?>" <?php if($variety['value']==$item_info['variety_id']){ echo "selected";}?>><?php echo $variety['text'];?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

<div style="<?php if(!($item['id']>0)){echo 'display:none';} ?>" class="row show-grid" id="competitor_variety_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_COMPETITOR_VARIETY');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <select id="competitor_variety_id" name="item_info[competitor_variety_id]" class="form-control">
            <option value=""><?php echo $this->lang->line('SELECT');?></option>
            <?php
            foreach($competitor_varieties as $competitor)
            {?>
                <option value="<?php echo $competitor['value']?>" <?php if($competitor['value']==$item_info['competitor_variety_id']){ echo "selected";}?>><?php echo $competitor['text'];?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>


<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-4">
        <?php
        if($CI->locations['division_id']>0)
        {
            ?>
            <label class="control-label"><?php echo $CI->locations['division_name'];?></label>
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
                    <option value="<?php echo $division['value']?>" <?php if($division['value']==$item_info['division_id']){ echo "selected";}?>><?php echo $division['text'];?></option>
                <?php
                }
                ?>
            </select>
        <?php
        }
        ?>
    </div>
</div>

<div style="<?php if(!(sizeof($zones)>0)){echo 'display:none';}?>" class="row show-grid" id="zone_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <?php
        if($CI->locations['zone_id']>0)
        {
            ?>
            <label class="control-label"><?php echo $CI->locations['zone_name'];?></label>
        <?php
        }
        else
        {
            ?>
            <select id="zone_id" class="form-control" ">
                <option value=""><?php echo $this->lang->line('SELECT');?></option>
                <?php
                foreach($zones as $zone)
                {?>
                    <option value="<?php echo $zone['value']?>" <?php if($zone['value']==$item_info['zone_id']){ echo "selected";}?>><?php echo $zone['text'];?></option>
                <?php
                }
                ?>
            </select>
        <?php
        }
        ?>
    </div>
</div>

<div style="<?php if(!(sizeof($territories)>0)){echo 'display:none';}?>" class="row show-grid" id="territory_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <?php
        if($CI->locations['territory_id']>0)
        {
            ?>
            <label class="control-label"><?php echo $CI->locations['territory_name'];?></label>
        <?php
        }
        else
        {
            ?>
            <select id="territory_id" class="form-control" >
                <option value=""><?php echo $this->lang->line('SELECT');?></option>
                <?php
                foreach($territories as $territory)
                {?>
                    <option value="<?php echo $territory['value']?>" <?php if($territory['value']==$item_info['territory_id']){ echo "selected";}?>><?php echo $territory['text'];?></option>
                <?php
                }
                ?>
            </select>
        <?php
        }
        ?>
    </div>
</div>

<div style="<?php if(!(sizeof($districts)>0)){echo 'display:none';}?>" class="row show-grid" id="district_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <?php
        if($CI->locations['district_id']>0)
        {
            ?>
            <label class="control-label"><?php echo $CI->locations['district_name'];?></label>
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
                    <option value="<?php echo $district['value']?>" <?php if($district['value']==$item_info['district_id']){ echo "selected";}?>><?php echo $district['text'];?></option>
                <?php
                }
                ?>
            </select>
        <?php
        }
        ?>
    </div>
</div>

<div style="<?php if(!(sizeof($upazillas)>0)){echo 'display:none';}?>" class="row show-grid" id="upazilla_id_container">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <?php
        if($CI->locations['upazilla_id']>0)
        {
            ?>
            <label class="control-label"><?php echo $CI->locations['upazilla_name'];?></label>
<!--            <input type="hidden" name="budget_details[upazilla_id]" value="--><?php //echo $CI->locations['upazilla_id'];?><!--">-->
        <?php
        }
        else
        {
            ?>
            <select id="upazilla_id" name="item_info[upazilla_id]" class="form-control">
                <option value=""><?php echo $this->lang->line('SELECT');?></option>
                <?php
                foreach($upazillas as $upazilla)
                {?>
                    <option value="<?php echo $upazilla['value']?>" <?php if($upazilla['value']==$item_info['upazilla_id']){ echo "selected";}?>><?php echo $upazilla['text'];?></option>
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
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ADDRESS');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <textarea class="form-control" id="address" name="item_info[address]" ><?php echo $item_info['address'];?></textarea>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PRESENT_CONDITION');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <textarea class="form-control" id="present_condition" name="item_info[present_condition]"><?php echo $item_info['present_condition']; ?></textarea>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FARMERS_EVALUATION');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <textarea class="form-control" id="farmers_evaluation" name="item_info[farmers_evaluation]"><?php echo $item_info['farmers_evaluation']; ?></textarea>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_SPECIFIC_DIFFERENCE');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <textarea class="form-control" id="diff_wth_com" name="item_info[diff_wth_com]"><?php echo $item_info['diff_wth_com']; ?></textarea>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_DATE');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <input type="text" name="item_info[expected_date]" id="expected_date" class="form-control datepicker" value="<?php echo System_helper::display_date($item_info['expected_date']); ?>"/>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_PARTICIPANT');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <input type="text" name="item_info[no_of_participant]" id="no_of_participant" class="form-control float_type_positive" value="<?php echo $item_info['no_of_participant'];?>"/>
    </div>
</div>




<div style="<?php if(!(sizeof($leading_farmers)>0)){echo 'display:none;';}?>" class="row show-grid" id="leading_farmer_container">

    <div id="leading_farmer_id" class="row show-grid">
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Expected Participant Through Leading Farmer :</label>
            </div>
        </div>
        <?php
        foreach($leading_farmers as $lead_farmer)
        {
        ?>
        <div class="row show-grid">
            <div class="col-xs-5">
                <label class="control-label pull-right"><?php echo $lead_farmer['text'].' ('.$lead_farmer['phone_no'].')';?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-3 col-xs-9">
                <input type="text" name="farmer_participant[<?php echo $lead_farmer['value'];?>]" class="form-control float_type_positive" value="<?php if(isset($participants[$lead_farmer['value']])){echo $participants[$lead_farmer['value']]['number'];}?>"/>
            </div>
        </div>
        <?php
        }
        ?>

    </div>
</div>





<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FIELD_DAY_BUDGET');?></label>
    </div>
</div>
<?php
 foreach($expense_items as $expense)
 {
 ?>
<div class="row show-grid">
     <div class="col-xs-5">
         <label class="control-label pull-right"><?php echo $expense['text'];?> <span style="color:#FF0000">*</span></label>
     </div>
     <div class="col-sm-3 col-xs-9">
         <input type="text" name="expense_budget[<?php echo $expense['value'];?>]" class="expense_budget form-control float_type_positive" value="<?php if(isset($expense_budget[$expense['value']])){echo $expense_budget[$expense['value']]['amount'];}?>"/>
     </div>
</div>
 <?php
 }
?>
<div style="display: none;" class="row show-grid" id="total_budget_container">
    <div class="col-xs-5">
        <label class="control-label pull-right"> Total Budget (Tk.)</label>
    </div>
    <div class="col-sm-3 col-xs-9">
        <label id="total_budget"><?php echo number_format($item_info['total_budget'],2);?></label>
    </div>
</div>


<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NEXT_SALES_TARGET');?> (kg)<span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <input type="text" name="item_info[sales_target]" id="sales_target" class="form-control float_type_positive" value="<?php echo $item_info['sales_target'];?>"/>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo 'TI '. $this->lang->line('LABEL_RECOMMENDATION');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <textarea class="form-control" id="remarks" name="item[remarks]"><?php echo $item['remarks']; ?></textarea>
    </div>
</div>



<div id="image" class="panel-collapse ">
    <div id="files_container" class="panel-collapse">
        <div style="overflow-x: auto;" class="row show-grid">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="min-width: 60px;">Image Type</th>
                    <th colspan="2" style="min-width: 270px;">ARM</th>
                    <th colspan="2" style="min-width: 270px;">Competitor</th>
<!--                    <th style="min-width: 60px;">Image Info.</th>-->
                </tr>
                </thead>

                <tbody>

                <?php
                foreach($picture_categories as $pic_cat)
                {
                    ?>

                    <tr>
                        <td style="min-width: 60px; color: #263238;"><b><?php echo $pic_cat['text'];?></b></td>

                        <td style="max-width: 300px; max-height: 300px;">
                            <div class="col-xs-4" id="image_arm_<?php echo $pic_cat['value'];?>">
                                <?php
                                $image='images/no_image.jpg';

                                if((isset($file_details[$pic_cat['value']]))&&(strlen($file_details[$pic_cat['value']]['arm_file_location'])>0))
                                {
                                    $image=$file_details[$pic_cat['value']]['arm_file_location'];
                                }
                                ?>
                                <img style="max-width: 300px;max-height: 300px;" src="<?php echo $CI->config->item('system_image_base_url').$image; ?>">
                            </div>
                        </td>
                        <td style="min-width: 80px; ">
                            <input type="file" class="browse_button" data-preview-container="#image_arm_<?php echo $pic_cat['value'];?>" name="arm_<?php echo $pic_cat['value'];?>">
                        <?php if($item['id']>0){ ?>
                            <input type="hidden"  name="image_info[<?php echo $pic_cat['value'];?>][arm_file_name]" value="<?php echo $file_details[$pic_cat['value']]['arm_file_name']?>">
                            <input type="hidden"  name="image_info[<?php echo $pic_cat['value'];?>][arm_file_location]" value="<?php echo $file_details[$pic_cat['value']]['arm_file_location']?>">
                       <?php }?>
                        </td>

                        <td style="max-width: 300px;max-height: 300px;">
                            <div class="col-xs-4" id="image_com_<?php echo $pic_cat['value'];?>">
                                <?php
                                $image='images/no_image.jpg';
                                if((isset($file_details[$pic_cat['value']]))&&(strlen($file_details[$pic_cat['value']]['competitor_file_location'])>0))
                                {
                                    $image=$file_details[$pic_cat['value']]['competitor_file_location'];
                                }
                                ?>
                                <img style="max-width: 300px;max-height: 300px;" src="<?php echo $CI->config->item('system_image_base_url').$image; ?>">
                            </div>
                        </td>
                        <td style="min-width: 80px;">
                            <input type="file" class="browse_button" data-preview-container="#image_com_<?php echo $pic_cat['value'];?>" name="competitor_<?php echo $pic_cat['value'];?>">
                            <?php if($item['id']>0){ ?>
                            <input type="hidden"  name="image_info[<?php echo $pic_cat['value'];?>][competitor_file_name]" value="<?php echo $file_details[$pic_cat['value']]['competitor_file_name']?>">
                            <input type="hidden"  name="image_info[<?php echo $pic_cat['value'];?>][competitor_file_location]" value="<?php echo $file_details[$pic_cat['value']]['competitor_file_location']?>">
                            <?php }?>
                        </td>


                    </tr>

                    <tr>
                        <td style="min-width: 60px; border: none;"></td>
                        <td style="min-width: 210px;border: none;">
                            <label>Remarks :</label>
                            <textarea class="form-control arm_remarks" name="arm_file_details_remarks[<?php echo $pic_cat['value'];?>]"><?php if(isset($file_details[$pic_cat['value']])){echo $file_details[$pic_cat['value']]['arm_file_remarks'];} ?></textarea>
                        </td>
                        <td style="min-width: 60px;border: none;"></td>
                        <td style="min-width: 210px;border: none;">
                            <label>Remarks :</label>
                            <textarea class="form-control com_remarks" name="com_file_details_remarks[<?php echo $pic_cat['value'];?>]"><?php if(isset($file_details[$pic_cat['value']])){echo $file_details[$pic_cat['value']]['competitor_file_remarks'];} ?></textarea>
                        </td>
                        <td style="min-width: 60px;border: none;"></td>

                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

</div>


<div class="clearfix"></div>
</form>




<script type="text/javascript">
    function findTotal()
    {
        var total=0;
        $(".expense_budget").each( function( index, element )
        {
            if($(this).val()==parseFloat($(this).val()))
            {
                total=total+parseFloat($(this).val());
            }
        });
        if(total=>0)
        {
            $('#total_budget_container').show();
        }
        $('#total_budget').html(number_format(total,2));
    }

//    function number_format(number, decimals, dec_point, thousands_sep)
//    {
//        number = (number + '')
//            .replace(/[^0-9+\-Ee.]/g, '');
//        var n = !isFinite(+number) ? 0 : +number,
//            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
//            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
//            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
//            s = '',
//            toFixedFix = function(n, prec) {
//                var k = Math.pow(10, prec);
//                return '' + (Math.round(n * k) / k)
//                    .toFixed(prec);
//            };
//        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
//        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
//            .split('.');
//        if (s[0].length > 3) {
//            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
//        }
//        if ((s[1] || '')
//            .length < prec) {
//            s[1] = s[1] || '';
//            s[1] += new Array(prec - s[1].length + 1)
//                .join('0');
//        }
//        return s.join(dec);
//    }

</script>



<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();

        $(".datepicker").datepicker({dateFormat : display_date_format});


        $(document).on("change","#division_id",function()
        {
            $("#zone_id").val("");
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#leading_farmer_id").val("");
            var division_id=$('#division_id').val();
            if(division_id>0)
            {
                $('#zone_id_container').show();
                $('#territory_id_container').hide();
                $('#district_id_container').hide();
                $('#upazilla_id_container').hide();
                $('#leading_farmer_container').hide();
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
                $('#leading_farmer_container').hide();
            }
        });
        $(document).on("change","#zone_id",function()
        {
            $("#territory_id").val("");
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#leading_farmer_id").val("");
            var zone_id=$('#zone_id').val();
            if(zone_id>0)
            {
                $('#territory_id_container').show();
                $('#district_id_container').hide();
                $('#upazilla_id_container').hide();
                $('#leading_farmer_container').hide();
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
                $('#leading_farmer_container').hide();
            }
        });
        $(document).on("change","#territory_id",function()
        {
            $("#district_id").val("");
            $("#upazilla_id").val("");
            $("#leading_farmer_id").val("");
            var territory_id=$('#territory_id').val();
            if(territory_id>0)
            {
                $('#district_id_container').show();
                $('#upazilla_id_container').hide();
                $('#leading_farmer_container').hide();
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
                $('#upazilla_id_container').hide();
                $('#district_id_container').hide();
                $('#leading_farmer_container').hide();
            }
        });
        $(document).on("change","#district_id",function()
        {
            $("#upazilla_id").val("");
            $("#leading_farmer_id").val("");
            var district_id=$('#district_id').val();
            if(district_id>0)
            {
                $('#upazilla_id_container').show();
                $('#leading_farmer_container').hide();
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
                $('#leading_farmer_container').hide();
            }
        });

        $(document).on("change","#upazilla_id",function()
        {
            $('#leading_farmer_container').empty();
            $("#leading_farmer_id").val("");
            var upazilla_id=$('#upazilla_id').val();
            if(upazilla_id>0)
            {
                $('#leading_farmer_container').show();
                $.ajax({
                    url: base_url+"common_controller/get_leading_farmers_by_upazillaid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{upazilla_id:upazilla_id,html_container_id:'#leading_farmer_container'},
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
                $('#leading_farmer_container').hide();
            }
        });


        $(document).on("change","#crop_id",function()
        {
            $("#crop_type_id").val("");
            $("#variety_id").val("");
            $("#competitor_variety_id").val("");
            var crop_id=$('#crop_id').val();
            if(crop_id>0)
            {
                $('#crop_type_id_container').show();
                $('#variety_id_container').hide();
                $('#competitor_variety_id_container').hide();

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
                $('#variety_id_container').hide();
                $('#competitor_variety_id_container').hide();
            }
        });
        $(document).on("change","#crop_type_id",function()
        {
            $("#variety_id").val("");
            $("#competitor_variety_id").val("");
            var crop_type_id=$('#crop_type_id').val();
            if(crop_type_id>0)
            {
                $('#variety_id_container').show();
                $('#competitor_variety_id_container').show();
                $.ajax({
                    url: base_url+"common_controller/get_dropdown_arm_and_upcoming_varieties_by_croptypeid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{crop_type_id:crop_type_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });

                $.ajax({
                    url: base_url+"common_controller/get_dropdown_competitor_varieties_by_croptypeid/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{crop_type_id:crop_type_id},
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
                $('#variety_id_container').hide();
                $('#competitor_variety_id_container').hide();
            }
        });


        $(document).on("change",".expense_budget",function()
        {
            findTotal();
        });


        $(".browse_button").filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});

    });
</script>








<!-- MIne Start-->

<!--<div class="panel-group" id="accordion">-->
<!---->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading">-->
<!--            <h4 class="panel-title">-->
<!--                <a class="accordion-toggle external" data-toggle="collapse"  data-target="#image" href="#">Upload Images</a>-->
<!--            </h4>-->
<!--        </div>-->
<!---->
<!--        <div id="image" class="panel-collapse collapse">-->
<!--            <div id="images_container">-->
<!--                <div style="overflow-x: auto;" class="row show-grid">-->
<!--                <table class="table table-bordered">-->
<!--                    <tbody>-->
<!---->
<!--                    --><?php
//                    foreach($details['images'] as $index=>$images)
//                    {
//                    ?>
<!---->
<!--                    <tr>-->
<!--                        <td>-->
<!---->
<!--                            <div class="col-xs-4">-->
<!--                                <label class="control-label pull-right">Picture</label>-->
<!--                            </div>-->
<!---->
<!---->
<!--                            <div class="preview_container_image col-xs-4 " id="preview_container_image_--><?php //echo $index+1;?><!--">-->
<!--                                --><?php
//                                $image=base_url('images/no_image.jpg');
//                                if(strlen($images)>0)
//                                {
//                                    $image=$images;
//                                }
//                                ?>
<!--                                <img style="max-width: 250px;" src="--><?php //echo $image;?><!--">-->
<!--                            </div>-->
<!---->
<!---->
<!--                            <div class="col-xs-4">-->
<!--                                <input type="file" id="image_--><?php //echo $index+1;?><!--" name="image_--><?php //echo $index+1;?><!--" data-current-id="--><?php //echo $index+1;?><!--" data-preview-container="#preview_container_image_--><?php //echo $index+1;?><!--" class="browse_button"><br>-->
<!--                                <button type="button" class="btn btn-danger system_button_add_delete">--><?php //echo $CI->lang->line('DELETE'); ?><!--</button>-->
<!--                            </div>-->
<!--                        </td>-->
<!---->
<!--                    </tr>-->
<!--                    --><?php
//                    }
//                    ?>
<!--                    </tbody>-->
<!--                </table>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row show-grid">-->
<!--                <div class="col-xs-4">-->
<!---->
<!--                </div>-->
<!--                <div class="col-xs-4">-->
<!--                    <button type="button" class="btn btn-warning system_button_add_more" data-current-id="">--><?php //echo $CI->lang->line('LABEL_ADD_MORE');?><!--</button>-->
<!--                </div>-->
<!--                <div class="col-xs-4">-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    </div>-->
<!---->
<!---->
<!--     <div class="panel panel-default">-->
<!--        <div class="panel-heading">-->
<!--            <h4 class="panel-title">-->
<!--                <a class="accordion-toggle external" data-toggle="collapse"  data-target="#pdf" href="#">Upload Video</a>-->
<!--            </h4>-->
<!--        </div>-->
<!--        <div id="pdf" class="panel-collapse collapse">-->
<!--            <div class="row show-grid">-->
<!--                <div class="col-xs-4">-->
<!--                    <label class="control-label pull-right">Video File</label>-->
<!--                </div>-->
<!--                <div class="col-xs-4" id="preview_container_video">-->
<!---->
<!--                </div>-->
<!--                <div class="col-xs-4">-->
<!--                    <input type="file" class="browse_button" data-preview-container="#preview_container_pdf" name="video">-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->

<!-- MIne End -->

<!-- MIne -->

<!--<div id="system_content_add_more" style="display: none;">-->
<!--    <table>-->
<!--        <tbody>-->
<!--        <tr>-->
<!--            <td>-->
<!--                <div class="col-xs-4">-->
<!--                    <label class="control-label pull-right">Picture</label>-->
<!--                </div>-->
<!---->
<!---->
<!--                <div class="preview_container_image col-xs-4 " >-->
<!--                    <img style="max-width: 250px;" src="--><?php //echo base_url('images/no_image.jpg');?><!--">-->
<!--                </div>-->
<!---->
<!---->
<!--                <div class="col-xs-4">-->
<!---->
<!--                    <input type="file" class="browse_button_new"><br>-->
<!--                    <button type="button" class="btn btn-danger system_button_add_delete">--><?php //echo $CI->lang->line('DELETE'); ?><!--</button>-->
<!--                </div>-->
<!--            </td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->

<!-- MIne -->