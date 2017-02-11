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
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FIELD_DAY_DATE');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($report_item[0]['date_of_fd']); ?></label>
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
                <label class="control-label"><?php echo number_format($info[0]['guest']);?></label>
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
        foreach($leading_farmers as $key=>$lead_farmer){
            ?>
            <div class="row show-grid">
                <div class="col-sm-4">
                    <label class="control-label pull-right"><?php echo $lead_farmer['text'].' ('.$lead_farmer['phone_no'].')';?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php if(isset($participants[$lead_farmer['value']])){echo $participants[$lead_farmer['value']]['number'];}?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php echo $participant_details[$index][$key]['number'];?></label>
                </div>
            </div>
        <?php } ?>

        <div style="" class="row show-grid">
            <div class="col-sm-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT');?> :</label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo $item_info['no_of_participant'];?></label>
            </div>
            <div class="col-sm-2 col-sm-4">
                <label class="control-label"><?php echo number_format($info[0]['no_of_participant']);?></label>
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
        foreach($expense_items as $key=>$expense_item){
            ?>
            <div class="row show-grid">
                <div class="col-sm-4">
                    <label class="control-label pull-right"><?php echo $expense_item['text']?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php if(isset($expense_budget[$expense_item['value']])){echo $expense_budget[$expense_item['value']]['amount'];}?></label>
                </div>
                <div class="col-sm-2 col-sm-4">
                    <label class="control-label"><?php echo number_format($expense_details[$index][$key]['amount']);?></label>
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
                <label id="total_budget"><?php echo number_format($info[0]['total_expense']);?> Tk.</label>
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
                <label id="total_budget"><?php echo $info[0]['next_sales_target'];?> kg</label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_COMMENT');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $info[0]['participant_comment'];?></label>
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
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDR_TIME_CREATED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date_time($info[0]['date_created']);?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDR_USER_CREATED');?> :</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $users_info[$info[0]['user_created']]['name'];?></label>
            </div>
        </div>

        <div style="overflow-x: auto;" class="row show-grid"></div>

        <div id="image" class="panel-collapse ">
            <div id="files_container" class="panel-collapse">
                <div style="overflow-x: auto;" class="row show-grid">

                    <table class="table table-bordered" style="width: 800px; margin-left: 50px;">
                        <thead>
                        <tr>
                            <th style="min-width: 60px;">File Type</th>
                            <th style="min-width: 60px;">File Name</th>
                            <th style="max-width: 270px;max-height: 200px;">Preview</th>
                            <th style="max-width: 100px;max-height: 200px;">Remarks</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td style="min-width: 60px; color: #263238;"><?php echo $video_file_details['file_type'];?></td>
                            <td style="min-width: 60px; color: #263238;"><b><?php echo $video_file_details['file_name'];?></b></td>
                            <td style="max-width: 300px; max-height: 300px;">
                                <div class="col-xs-4">
                                <video width="300" controls>
                                    <source src="<?php echo $CI->config->item('system_image_base_url').$video_file_details['file_location'];?>" type="video/mp4">
                                </video>
                                    <a style="margin-left: 200px;" href="<?php echo $CI->config->item('system_image_base_url').$video_file_details['file_location'];?>" class="btn btn-primary external">Download</a>
                                 </div>
                            </td>
                            <td style="max-width: 300px;max-height: 300px;">

                            </td>
                        </tr>
                        <?php
                        foreach($file_details as $file)
                        {
                            ?>

                            <tr>
                                <td style="min-width: 60px; color: #263238;"><?php echo $file['file_type'];?></td>
                                <td style="min-width: 60px; color: #263238;"><b><?php echo $file['file_name'];?></b></td>
                                <td style="max-width: 300px; max-height: 300px;">
                                    <div class="col-xs-4">
                                        <img style="max-width: 300px;max-height: 300px;"
                                             src="<?php echo $CI->config->item('system_image_base_url').$file['file_location']; ?>"
                                             class="Tooltip" title="<h5><?php echo $file['file_remarks']?></h5>">
                                    </div>
                                </td>
                                <td style="max-width: 300px;max-height: 300px;">
                                    <h5><?php echo $file['file_remarks']?></h5>
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
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDR_TIME_CREATED');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo System_helper::display_date_time($info[0]['date_created']);?></label>
                    </div>
                </div>
                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FDR_USER_CREATED');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo $users_info[$info[0]['user_created']]['name'];?></label>
                    </div>
                </div>

                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_GUEST');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo number_format($info[0]['guest']);?></label>
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
                foreach($leading_farmers as $key=>$lead_farmer){
                    ?>
                    <div class="row show-grid">
                        <div class="col-sm-4">
                            <label class="control-label pull-right"><?php echo $lead_farmer['text'].' ('.$lead_farmer['phone_no'].')';?></label>
                        </div>
                        <div class="col-sm-2 col-sm-4">
                            <label class="control-label"><?php if(isset($participants[$lead_farmer['value']])){echo $participants[$lead_farmer['value']]['number'];}?></label>
                        </div>
                        <div class="col-sm-2 col-sm-4">
                            <label class="control-label"><?php echo $participant_details[$index][$key]['number'];?></label>
                        </div>
                    </div>
                <?php } ?>
                <div style="" class="row show-grid">
                    <div class="col-sm-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT');?> :</label>
                    </div>
                    <div class="col-sm-2 col-sm-4">
                        <label class="control-label"><?php echo $item_info['no_of_participant'];?></label>
                    </div>
                    <div class="col-sm-2 col-sm-4">
                        <label class="control-label"><?php echo number_format($info[0]['no_of_participant']);?></label>
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
                foreach($expense_items as $key=>$expense_item){
                    ?>
                    <div class="row show-grid">
                        <div class="col-sm-4">
                            <label class="control-label pull-right"><?php echo $expense_item['text']?></label>
                        </div>
                        <div class="col-sm-2 col-sm-4">
                            <label class="control-label"><?php if(isset($expense_budget[$expense_item['value']])){echo $expense_budget[$expense_item['value']]['amount'];}?></label>
                        </div>
                        <div class="col-sm-2 col-sm-4">
                            <label class="control-label"><?php echo number_format($expense_details[$index][$key]['amount']);?></label>
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
                        <label id="total_budget"><?php echo number_format($info[0]['total_expense']);?> Tk.</label>
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
                        <label id="total_budget"><?php echo $info[0]['next_sales_target'];?> kg</label>
                    </div>
                </div>
                <div style="" class="row show-grid">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_PARTICIPANT_COMMENT');?> :</label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <label class="control-label"><?php echo $info[0]['participant_comment'];?></label>
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
        $('[class="Tooltip"]').tooltip({
            animated: 'fade',
            placement: 'bottom',
            html: true
        });
    });
</script>

<!--<script type="text/javascript">-->
<!--    $(document).ready(function(){-->
<!---->
<!--// Method 1 - uses 'data-toggle' to initialize-->
<!--        $('[data-toggle="myToolTip"]').tooltip();-->
<!---->
<!--        /* - - - - - - - - - - - - - - - - - - - */-->
<!---->
<!--// Method 2 - uses the id, class or native tag, could use .btn as class-->
<!---->
<!--        $('button').tooltip();-->
<!---->
<!--// options set in JS by class-->
<!--        $(".tip-top").tooltip({-->
<!--            placement : 'top'-->
<!--        });-->
<!--        $(".tip-right").tooltip({-->
<!--            placement : 'right'-->
<!--        });-->
<!--        $(".tip-bottom").tooltip({-->
<!--            placement : 'bottom'-->
<!--        });-->
<!--        $(".tip-left").tooltip({-->
<!--            placement : 'left',-->
<!--            html : true-->
<!--        });-->
<!---->
<!--        $(".tip-auto").tooltip({-->
<!--            placement : 'auto',-->
<!--            html : true-->
<!--        });-->
<!---->
<!--    });-->
<!--</script>-->
