<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$CI->load->view("action_buttons",$action_data);
?>
<div class="row widget">
<div class="widget-header">
    <div class="title">
        <?php echo $title; ?>
    </div>
    <div class="clearfix"></div>
</div>


<div class="panel-group" id="accordion">

<?php
$index=0;
$revisions=array_keys($info_details);
$max_revision=$revisions[sizeof($revisions)-1];
foreach($info_details as $revision=>$info)
{
    $index++;
    ?>



    <?php
    if($index==1){
        ?>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-left">Revision : <?php echo $max_revision.' (Latest)';?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DATE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($item_info['date']); ?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['crop_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_TYPE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['crop_type_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_VARIETY_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['variety_name'];?></label>
            </div>
        </div>
        <?php
        if($item_info['com_variety_name']){
            ?>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_COMPETITOR_NAME');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo $item_info['com_variety_name'];?></label>
                </div>
            </div>
        <?php }?>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['division_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ZONE_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['zone_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['territory_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['district_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['upazilla_name'];?></label>
            </div>
        </div>


        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ADDRESS');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['address'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PRESENT_CONDITION');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['present_condition'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FARMERS_EVALUATION');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['farmers_evaluation'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_SPECIFIC_DIFFERENCE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['diff_wth_com'];?></label>
            </div>
        </div>


        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_DATE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($info[0]['expected_date']); ?></label>
            </div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_THROUGH_LEAD_FARMER');?></label>
            </div>
        </div>
        <?php
        foreach($participant_details[$index] as $key=>$participant_detail){
            ?>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $leading_farmers[$key]['text'].' ('.$leading_farmers[$key]['phone_no'].')';?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo $participant_detail['number'];?></label>
                </div>
            </div>
        <?php } ?>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_PARTICIPANT');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo number_format($info[0]['no_of_participant']);?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FIELD_DAY_BUDGET');?></label>
            </div>
        </div>
        <?php
        foreach($expense_items as $key=>$expense_item){
            ?>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $expense_item['text']?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo number_format($expense_details[$index][$key]['amount']);?></label>
                </div>
            </div>
        <?php } ?>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"> Total Budget :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label id="total_budget"><?php echo number_format($info[0]['total_budget']);?> Tk.</label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NEXT_SALES_TARGET');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label id="total_budget"><?php echo $info[0]['sales_target'];?> kg</label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">TI <?php echo $this->lang->line('LABEL_RECOMMENDATION');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['remarks'];?></label>
            </div>
        </div>

        <?php if($item_info['status_requested']==$CI->config->item('system_status_po_request_requested') || $item_info['status_requested']==$CI->config->item('system_status_po_request_rejected')) {?>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right">ZI <?php echo $this->lang->line('LABEL_RECOMMENDATION');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo $item_info['remarks_requested'];?></label>
                </div>
            </div>

        <?php } ?>
        <?php if($item_info['status_approved']==$CI->config->item('system_status_po_request_approved') || $item_info['status_approved']==$CI->config->item('system_status_po_approval_rejected')) {?>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right">DI <?php echo $this->lang->line('LABEL_RECOMMENDATION');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo $item_info['remarks_approved'];?></label>
                </div>
            </div>

        <?php } ?>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_TIME_CREATED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date_time($info[0]['date_created']);?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_USER_CREATED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $users_info[$info[0]['user_created']]['name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_REQUESTED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['status_requested'];?></label>
            </div>
        </div>
        <?php
        if($item_info['status_requested']==$CI->config->item('system_status_po_request_requested'))
        {
            ?>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_TIME_REQUESTED');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo System_helper::display_date_time($item_info['date_requested']);?></label>
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_USER_REQUESTED');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo $users[$item_info['user_requested']]['name'];?></label>
                </div>
            </div>
        <?php
        }
        ?>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_APPROVAL');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['status_approved'];?></label>
            </div>
        </div>
        <?php
        if(($item_info['status_approved']==$CI->config->item('system_status_po_approval_approved'))||($item_info['status_approved']==$CI->config->item('system_status_po_approval_rejected')))
        {
            ?>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_TIME_APPROVED');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo System_helper::display_date_time($item_info['date_approved']);?></label>
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_USER_APPROVED');?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php echo $users[$item_info['user_approved']]['name'];?></label>
                </div>
            </div>
        <?php
        }
        ?>

        <div style="overflow-x: auto;" class="row show-grid"></div>
        <div id="image" class="panel-collapse ">
            <div id="files_container" class="panel-collapse">
                <div style="overflow-x: auto;" class="row show-grid">

                    <table class="table table-bordered" style="width: 800px; margin-left: 50px;">
                        <thead>
                        <tr>
                            <th style="min-width: 60px;">Image Type</th>
                            <th style="max-width: 270px;max-height: 200px;">ARM</th>
                            <th style="max-width: 270px;max-height: 200px;">Competitor</th>
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
                                        <img style="max-width: 300px;max-height: 300px;" src="<?php echo $CI->config->item('system_image_base_url').$image; ?>" data-toggle="Tooltip" title="<h5><?php echo $file_details[$pic_cat['value']]['arm_file_remarks']?></h5>">
                                    </div>
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
                                        <img style="max-width: 300px;max-height: 300px;" src="<?php echo $CI->config->item('system_image_base_url').$image; ?>" data-toggle="Tooltip" title="<h5><?php echo $file_details[$pic_cat['value']]['competitor_file_remarks']?></h5>">
                                    </div>
                                </td>
                            </tr>


                        <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php
    }
    else{
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle external" data-toggle="collapse"  data-target="#collapse_<?php echo $index;?>" href="#">
                        Revision : <?php echo ($max_revision-$revision+1);?></a>
                </h4>
            </div>
            <div id="collapse_<?php echo $index;?>" class="panel-collapse collapse">
                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_TIME_CREATED');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo System_helper::display_date_time($info[0]['date_created']);?></label>
                    </div>
                </div>
                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_USER_CREATED');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo $users_info[$info[0]['user_created']]['name'];?></label>
                    </div>
                </div>

                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_DATE');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo System_helper::display_date($info[0]['expected_date']); ?></label>
                    </div>
                </div>
                <div class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_THROUGH_LEAD_FARMER');?></label>
                    </div>
                </div>
                <?php
                foreach($participant_details[$index] as $key=>$participant_detail){
                    ?>
                    <div class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $leading_farmers[$key]['text'].' ('.$leading_farmers[$key]['phone_no'].')';?></label>
                        </div>
                        <div class="col-sm-4 col-xs-8">
                            <label class="control-label"><?php echo $participant_detail['number'];?></label>
                        </div>
                    </div>
                <?php } ?>
                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_PARTICIPANT');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo number_format($info[0]['no_of_participant']);?></label>
                    </div>
                </div>
                <div class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FIELD_DAY_BUDGET');?></label>
                    </div>
                </div>
                <?php
                foreach($expense_items as $key=>$expense_item){
                    ?>
                    <div class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $expense_item['text']?></label>
                        </div>
                        <div class="col-sm-4 col-xs-8">
                            <label class="control-label"><?php echo number_format($expense_details[$index][$key]['amount']);?></label>
                        </div>
                    </div>
                <?php } ?>
                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"> Total Budget :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label id="total_budget"><?php echo number_format($info[0]['total_budget']);?> Tk.</label>
                    </div>
                </div>
                <div class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NEXT_SALES_TARGET');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label id="total_budget"><?php echo $info[0]['sales_target'];?> kg</label>
                    </div>
                </div>
                <div style="overflow-x: auto;" class="row show-grid"></div>
            </div>
        </div>
    <?php }?>
<?php }?>
</div>

</div>

<div class="clearfix"></div>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $('[data-toggle="Tooltip"]').tooltip({
            animated: 'fade',
            placement: 'bottom',
            html: true
        });
    });
</script>
