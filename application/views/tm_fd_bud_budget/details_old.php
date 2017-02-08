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
        <?php if($item_info['com_variety_name']){
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
                <label class="control-label"><?php echo System_helper::display_date($item_info['expected_date']); ?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_PARTICIPANT');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $item_info['no_of_participant'];?></label>
            </div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_THROUGH_LEAD_FARMER');?></label>
            </div>
        </div>
        <?php
        foreach($leading_farmers as $lead_farmer)
        {  ?>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $lead_farmer['text'].' ('.$lead_farmer['phone_no'].')';?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php if(isset($participants[$lead_farmer['value']])){echo number_format($participants[$lead_farmer['value']]['number']);}?></label>
                </div>
            </div>
        <?php
        }
        ?>


        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FIELD_DAY_BUDGET');?></label>
            </div>
        </div>
        <?php
        foreach($expense_items as $expense)
        {  ?>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $expense['text'];?> :</label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <label class="control-label"><?php if(isset($expense_budget[$expense['value']])){echo number_format($expense_budget[$expense['value']]['amount']);}?></label>
                </div>
            </div>
        <?php
        }
        ?>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"> Total Budget :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label id="total_budget"><?php echo number_format($item_info['total_budget']);?> Tk.</label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NEXT_SALES_TARGET');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label id="total_budget"><?php echo $item_info['sales_target'];?> kg</label>
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
                <label class="control-label"><?php echo System_helper::display_date_time($item_info['date_created']);?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDB_USER_CREATED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $users[$item_info['user_created']]['name'];?></label>
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

    </div>

<div class="clearfix"></div>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
    });
</script>
