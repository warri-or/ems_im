<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
?>

<div class="row widget">

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo '</br>'. $CI->lang->line('LABEL_FIELD_DAY_DATE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo '</br>'. System_helper::display_date($report_item[0]['date_of_fd']); ?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_REPORTING_DATE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($report_item[0]['date']); ?></label>
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
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_GUEST');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo number_format($info['guest']);?></label>
            </div>
        </div>



        <div class="row show-grid">
            <div class="col-xs-4">
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
        foreach($participants as $key=>$participant)
        {
            ?>
            <div class="row show-grid">
                <div class="col-sm-4">
                    <label class="control-label pull-right"><?php echo $leading_farmers[$key]['text'].' ('.$leading_farmers[$key]['phone_no'].')';?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php if(isset($participant['number'])){echo $participant['number'];}?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php echo $farmers[$key]['number'];?></label>
                </div>
            </div>
        <?php } ?>

        <div style="" class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_THROUGH_CUSTOMER');?></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo $item_info['participant_through_customer'];?></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo number_format($info['participant_through_customer']);?></label>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_THROUGH_OTHERS');?></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo $item_info['participant_through_others'];?></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo number_format($info['participant_through_others']);?></label>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_EXPECTED_PARTICIPANT');?> :</label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo $item_info['no_of_participant'];?></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo number_format($info['total_participant']);?></label>
            </div>
        </div>


        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Field Day Expense :</label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><u>Budgeted</u></label>
            </div>
            <div class="col-sm-2 col-xs-4">
                <label class="control-label"><u>Actual</u></label>
            </div>
        </div>
        <?php
        foreach($expense_report as $key=>$report){
            ?>
            <div class="row show-grid">
                <div class="col-sm-4">
                    <label class="control-label pull-right"><?php echo $expense_items[$key]['text']?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php if(isset($expense_budget[$key]['amount'])){echo $expense_budget[$key]['amount'];}?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php echo number_format($report['amount']);?></label>
                </div>
            </div>
        <?php } ?>

        <div style="" class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"> Total Amount :</label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label id="total_budget"><?php echo number_format($item_info['total_budget']);?> Tk.</label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label id="total_budget"><?php echo number_format($info['total_expense']);?> Tk.</label>
            </div>
        </div>

        <div class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NEXT_SALES_TARGET');?> :</label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label id="total_budget"><?php echo $item_info['sales_target'];?> kg</label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label id="total_budget"><?php echo $info['next_sales_target'];?> kg</label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_COMMENT');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $info['participant_comment'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_RECOMMENDATION');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $report_item[0]['recommendation'];?></label>
            </div>
        </div>


        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDR_TIME_CREATED');?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date_time($info['date_created']);?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDR_USER_CREATED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $user_info[$info['user_created']]['name'];?></label>
            </div>
        </div>
        <div class="panel-group" id="accordion">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle external" data-toggle="collapse"  data-target="#collapse_2" href="#">
                            Before Field Day (Files)</a>
                    </h4>
                </div>
                <div id="collapse_2" class="panel-collapse collapse">

                    <table class="table table-bordered" style="width: 700px; margin-left: 50px;">
                        <thead>
                        <tr>
                            <th style="min-width: 60px;">Image Type</th>
                            <th style="max-width: 270px;max-height: 200px;">ARM</th>
                            <th style="max-width: 270px;max-height: 200px;">Competitor</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        foreach($picture_categories as $pic_cat)
                        {
                            ?>

                            <tr>
                                <td style="min-width: 60px; color: #263238;"><b><?php echo $pic_cat['text'];?></b></td>
                                <td style="max-width: 270px; max-height: 200px;">
                                    <div class="col-xs-4" id="image_arm_<?php echo $pic_cat['value'];?>">
                                        <?php
                                        $image='images/no_image.jpg';

                                        if((isset($b_fd_file_details[$pic_cat['value']]))&&(strlen($b_fd_file_details[$pic_cat['value']]['arm_file_location'])>0))
                                        {
                                            $image=$b_fd_file_details[$pic_cat['value']]['arm_file_location'];
                                        }
                                        ?>
                                        <img style="max-width: 250px;max-height: 200px;" src="<?php echo $CI->config->item('system_image_base_url').$image; ?>"class="Tooltip" title="<h5><?php echo $b_fd_file_details[$pic_cat['value']]['arm_file_remarks']?></h5>">
                                    </div>
                                </td>
                                <td style="max-width: 270px;max-height: 200px;">
                                    <div class="col-xs-4" id="image_com_<?php echo $pic_cat['value'];?>">
                                        <?php
                                        $image='images/no_image.jpg';
                                        if((isset($b_fd_file_details[$pic_cat['value']]))&&(strlen($b_fd_file_details[$pic_cat['value']]['competitor_file_location'])>0))
                                        {
                                            $image=$b_fd_file_details[$pic_cat['value']]['competitor_file_location'];
                                        }
                                        ?>
                                        <img style="max-width: 250px;max-height: 200px;" src="<?php echo $CI->config->item('system_image_base_url').$image; ?>" class="Tooltip" title="<h5><?php echo $b_fd_file_details[$pic_cat['value']]['competitor_file_remarks']?></h5>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="max-width: 100px;"><b>Remarks (<?php echo $pic_cat['text'];?>)</b></td>
                                <td style="max-width: 270px;"><p style="text-align:justify;margin-left: 15px;margin-right: 15px;"><?php echo $b_fd_file_details[$pic_cat['value']]['arm_file_remarks']?></p></td>
                                <td style="max-width: 270px;"><p style="text-align:justify;margin-left: 15px;margin-right: 15px;"><?php echo $b_fd_file_details[$pic_cat['value']]['competitor_file_remarks']?></p></td>
                            </tr>

                        <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle external" data-toggle="collapse"  data-target="#collapse_1" href="#">
                        After Field Day (Files)</a>
                </h4>
            </div>
            <div id="collapse_1" class="panel-collapse collapse">

                    <table class="table table-bordered" style="width: 700px; margin-left: 50px;">
                        <thead>
                        <tr>
                            <th style="min-width: 100px;">File Type</th>
                            <th style="min-width: 100px;">File Name</th>
                            <th style="max-width: 270px;max-height: 200px;">Preview</th>
                            <th style="max-width: 100px;max-height: 200px;">Remarks</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td style="min-width: 100px; color: #263238;"><?php echo $video_file_details['file_type'];?></td>
                            <td style="min-width: 100px; color: #263238;"><b><?php echo $video_file_details['file_name'];?></b></td>
                            <td style="max-width: 270px; max-height: 200px;">
                                <div class="col-xs-4">
                                    <video width="270" controls>
                                        <source src="<?php echo $CI->config->item('system_image_base_url').$video_file_details['file_location']; ?>"
                                                type="<?php echo $video_file_details['file_type'];?>"></video>
                                    <a style="margin-left: 175px;"  target="_blank" href="<?php echo $CI->config->item('system_image_base_url').$video_file_details['file_location']; ?>" class="btn btn-primary external">Download</a>
                                </div>
                            </td>
                            <td style="max-width: 100px;max-height: 200px;">
                            </td>
                        </tr>
                        <?php
                        foreach($a_fd_file_details as $file)
                        {
                            ?>

                            <tr>
                                <td style="min-width: 100px; color: #263238;"><?php echo $file['file_type'];?></td>
                                <td style="min-width: 100px; color: #263238;"><b><?php echo $file['file_name'];?></b></td>
                                <td style="max-width: 270px; max-height: 200px;">
                                    <div class="col-xs-4">
                                        <img style="max-width: 270px;max-height: 200px;"
                                             src="<?php echo $CI->config->item('system_image_base_url').$file['file_location']; ?>">
                                    </div>
                                </td>
                                <td style="max-width: 100px;max-height: 200px;">
                                    <h5><?php echo $file['file_remarks']?></h5>
                                </td>
                            </tr>


                        <?php } ?>

                        </tbody>
                    </table>
                </div>
                </div>


            </div>
        </div>



<div class="clearfix"></div>



<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $('[class="Tooltip"]').tooltip({
            animated: 'fade',
            placement: 'bottom',
            html: true
        });
    });
</script>

