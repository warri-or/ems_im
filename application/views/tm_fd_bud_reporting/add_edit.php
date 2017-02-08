<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$action_data["action_clear"]='#save_form';

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
<input type="hidden" id="budget_id" name="item[budget_id]" value="<?php echo $item['budget_id']; ?>" />
<div class="row widget">
<div class="widget-header">
    <div class="title">
        <?php echo $title; ?>
    </div>
    <div class="clearfix"></div>
</div>

<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_REPORTING_DATE');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-3 col-xs-9">
        <input type="text" name="item[date]" id="date" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date']);?>" />
    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FIELD_DAY_DATE');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-3 col-xs-9">
        <input type="text" name="item[date_of_fd]" id="date_of_fd" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date_of_fd']);?>" />
    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['crop_name'];?></label>
    </div>
</div>

<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_TYPE');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['crop_type_name'];?></label>
    </div>
</div>

<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_VARIETY_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-4">
        <label class="control-label"><?php echo $item_info['variety_name'];?></label>
    </div>
</div>

<?php
if($item_info['com_variety_name']){
    ?>
    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_COMPETITOR_NAME');?></label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label class="control-label"><?php echo $item_info['com_variety_name'];?></label>
        </div>
    </div>
<?php }?>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['division_name'];?></label>
    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['zone_name'];?></label>
    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['territory_name'];?></label>
    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['district_name'];?></label>
    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <label class="control-label"><?php echo $item_info['upazilla_name'];?></label>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_GUEST');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-3 col-xs-9">
        <input type="text" name="new_item[guest]" id="guest" class="form-control float_type_positive" value="<?php echo $new_item['guest']; ?>"/>
    </div>
</div>
<div style="<?php if(!(sizeof($leading_farmers)>0)){echo 'display:none;';}?>" class="row show-grid" id="leading_farmer_container">

    <div id="leading_farmer_id" class="row show-grid">
        <div class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_THROUGH_LEAD_FARMER');?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><u>Expected</u></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><u>Actual</u></label>
            </div>
        </div>
        <?php
        foreach($leading_farmers as $lead_farmer)
        {
            ?>
            <div class="row show-grid">
                <div class="col-sm-4">
                    <label class="control-label pull-right"><?php echo $lead_farmer['text'].' ('.$lead_farmer['phone_no'].')';?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php if(isset($participants[$lead_farmer['value']])){echo $participants[$lead_farmer['value']]['number'];}?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <input type="text" name="farmers[<?php echo $lead_farmer['value'];?>]" id="farmers[<?php echo $lead_farmer['value'];?>]" class="form-control float_type_positive" value="<?php if(isset($farmers[$lead_farmer['value']])){echo $farmers[$lead_farmer['value']]['number'];}?>"/>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
</div>
<div style="" class="row show-grid">
    <div class="col-sm-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-2 col-sm-4">
        <label class="control-label"><?php echo $item_info['no_of_participant'];?></label>
    </div>
    <div class="col-sm-2 col-sm-4">
        <input type="text" name="new_item[no_of_participant]" id="no_of_participant" class="form-control float_type_positive" value="<?php echo $new_item['no_of_participant']; ?>"/>
    </div>
</div>
<div class="row show-grid">
    <div class="col-sm-4">
        <label class="control-label pull-right">Field Day Expense :</label>
    </div>
</div>
<div class="row show-grid">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-2 col-sm-4">
        <label class="control-label"><u>Budgeted</u></label>
    </div>
    <div class="col-sm-2 col-sm-4">
        <label class="control-label"><u>Actual</u></label>
    </div>
</div>
<?php
foreach($expense_items as $expense)
{
    ?>
    <div class="row show-grid">
        <div class="col-sm-4">
            <label class="control-label pull-right"><?php echo $expense['text'];?></label>
        </div>
        <div class="col-sm-2 col-sm-4">
            <label class="control-label"><?php if(isset($expense_budget[$expense['value']])){echo $expense_budget[$expense['value']]['amount'];}?></label>
        </div>
        <div class="col-sm-2 col-sm-4">
            <input type="text" name="expense_report[<?php echo $expense['value'];?>]" id="expense_report[<?php echo $expense['value'];?>]" class="form-control float_type_positive total_expense" value="<?php if(isset($expense_report[$expense['value']])){echo $expense_report[$expense['value']]['amount'];}?>"/>
        </div>
    </div>
<?php
}
?>
<div style="" class="row show-grid">
    <div class="col-sm-4">
        <label class="control-label pull-right"> Total Amount :</label>
    </div>
    <div class="col-sm-2 col-sm-4">
        <label id="total_budget"><?php echo number_format($item_info['total_budget']);?> Tk.</label>
    </div>
    <div class="col-sm-2 col-sm-4" id="total_expense_container" style="<?php if($item['id']==0){echo 'display: none';}?>">
        <label id="total_expense"><?php echo number_format($new_item['total_expense'],2);?></label>
    </div>
</div>

<div class="row show-grid">
    <div class="col-sm-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NEXT_SALES_TARGET');?> (kg)<span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-2 col-sm-4">
        <label id="sales_target"><?php echo $item_info['sales_target'];?> kg</label>
    </div>
    <div class="col-sm-2 col-sm-4">
        <input type="text" name="new_item[next_sales_target]" id="next_sales_target" class="form-control float_type_positive" value="<?php echo $new_item['next_sales_target']; ?>"/>
    </div>
</div>

<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_COMMENT');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-3 col-xs-9">
        <textarea class="form-control" id="participant_comment" name="new_item[participant_comment]"><?php echo $new_item['participant_comment'];?></textarea>
    </div>
</div>
<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_RECOMMENDATION');?><span style="color:#FF0000">*</span></label>
    </div>
    <div class="col-sm-3 col-xs-9">
        <textarea class="form-control" id="recommendation" name="item[recommendation]"><?php echo $item['recommendation']; ?></textarea>
    </div>
</div>

<div class="row show-grid">
    <?php
    $exp=explode('.',$video_file_details['file_name']);
    $is_video=false;
    if(sizeof($exp)>0)
    {
        $ext=strtolower($exp[sizeof($exp)-1]);
        if(($ext=='mkv') || ($ext=='wmv') || ($ext=='mp4') || ($ext=='3gp') || ($ext=='ftv'))
        {
            $is_video=true;
        }
    }
    ?>
    <div class="col-xs-2">
        <label class="control-label">Upload a Video File</label>
    </div>
    <div class="col-xs-2">
        <input type="file" class="browse_button" data-preview-container="#video" name="video">
        <input type="hidden" name="video_file" value="<?php echo $video_file_details['file_name'];?>">
    </div>
    <div class="col-xs-4" id="video">
        <?php
        if($is_video)
        {
            echo $video_file_details['file_name'];
        }
        else
        {
            echo 'Please Upload Video File Only';
        }
        ?>
    </div>
</div>

<!--<video style="max-width: 250px;"> <source src="--><?php //echo $CI->config->item('system_image_base_url').$video_file_details['file_location']; ?><!--"></video>-->

<div id="files_container">
    <div style="overflow-x: auto;" class="row show-grid">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="min-width: 250px;">Program's Picture</th>
                <th style="min-width: 50px;">Upload</th>
                <th style="max-width: 150px;">Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($file_details as $index=>$file)
            {
                $exp=explode('.',$file['file_name']);
                $is_image=false;
                if(sizeof($exp)>0)
                {
                    $ext=strtolower($exp[sizeof($exp)-1]);
                    if(($ext=='jpg') || ($ext=='png') || ($ext=='gif') || ($ext=='jpeg'))
                    {
                        $is_image=true;
                    }
                }
                ?>
                <tr>
                    <td>
                        <div class="preview_container_file" id="preview_container_file_<?php echo $index+1;?>">
                            <?php
                            if($is_image)
                            {
                                ?>
                                <img style="max-width: 250px;" src="<?php echo $CI->config->item('system_image_base_url').$file['file_location']; ?>">
                            <?php
                            }
                            else
                            {
                                echo $file['file_name'];
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <input type="file" id="file_<?php echo $index+1; ?>" name="file_<?php echo $index+1; ?>" data-current-id="<?php echo $index+1;?>" data-preview-container="#preview_container_file_<?php echo $index+1;?>" class="browse_button"><br>
                        <button type="button" class="btn btn-danger system_button_add_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
                        <input type="hidden" name="files[<?php echo $index+1; ?>]" value="<?php  echo $file['file_name'];?>">
                    </td>
                    <td style="max-width: 100px;">
                        <label>Remarks :</label>
                        <textarea class="form-control remarks" id="remarks" name="remarks[<?php echo $index+1;?>]"><?php if(isset($file['file_remarks'])){echo $file['file_remarks'];} ?></textarea>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row show-grid">
    <div class="col-xs-4">

    </div>
    <div class="col-xs-4">
        <button type="button" class="btn btn-warning system_button_add_more" data-current-id="<?php echo sizeof($file_details);?>"><?php echo $CI->lang->line('LABEL_ADD_MORE');?></button>
    </div>
    <div class="col-xs-4">

    </div>
</div>

</div>

<div class="clearfix"></div>
</form>

<div id="system_content_add_more" style="display: none;">
    <table>
        <tbody>
        <tr>
            <td>
                <div class="preview_container_file">
                </div>
            </td>
            <td>
                <input type="file" class="browse_button_new"><br>
                <button type="button" class="btn btn-danger system_button_add_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
                <input type="hidden" class="is_preview" name="" value="0">
            </td>
            <td>
                <textarea class="form-control remarks"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>


<script type="text/javascript">
    function findTotal()
    {
        var total=0;
        $(".total_expense").each( function( index, element )
        {
            if($(this).val()==parseFloat($(this).val()))
            {
                total=total+parseFloat($(this).val());
            }
        });
        if(total=>0)
        {
            $('#total_expense_container').show();
        }
        $('#total_expense').html(number_format(total,2));
    }

</script>

<script type="text/javascript">

jQuery(document).ready(function()
{
    turn_off_triggers();
    $(".datepicker").datepicker({dateFormat : display_date_format});
    $(".browse_button").filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});
    $(document).on("click", ".system_button_add_more", function(event)
    {
        var current_id=parseInt($(this).attr('data-current-id'));
        current_id=current_id+1;
        $(this).attr('data-current-id',current_id);
        var content_id='#system_content_add_more table tbody';

        $(content_id+' .browse_button_new').attr('data-preview-container','#preview_container_file_'+current_id);
        $(content_id+' .browse_button_new').attr('name','file_'+current_id);
        $(content_id+' .browse_button_new').attr('id','file_'+current_id);
        $(content_id+' .remarks').attr('name','remarks['+current_id+']');
        $(content_id+' .preview_container_file').attr('id','preview_container_file_'+current_id);
        $(content_id+' .is_preview').attr('name','files['+current_id+']');

        var html=$(content_id).html();
        $("#files_container tbody").append(html);

        $(content_id+' .browse_button_new').removeAttr('name');
        $(content_id+' .browse_button_new').removeAttr('data-preview-container');
        $(content_id+' .browse_button_new').removeAttr('id');
        $(content_id+' .preview_container_file').removeAttr('id');
        $('#file_'+current_id).filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});

    });
    $(document).on("click", ".system_button_add_delete", function(event)
    {
        $(this).closest('tr').remove();
    });

    $(document).on("change",".total_expense",function()
    {
        findTotal();
    });

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