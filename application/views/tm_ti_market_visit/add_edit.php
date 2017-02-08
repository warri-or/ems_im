<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    $action_data["action_back"]=base_url($CI->controller_url);
    $action_data["action_save"]='#save_form';
    $action_data["action_clear"]='#save_form';
    $CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $visit['id']; ?>" />
    <input type="hidden" name="visit[date]" value="<?php echo $visit['date']; ?>">
    <input type="hidden" name="visit[setup_id]" value="<?php echo $visit['setup_id']; ?>">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>


        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DATE');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($visit['date']);?></label>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DAY');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo date('l',$visit['date']);?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_SHIFT');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $visit['shift_name'];?></label>
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <?php
                    if($visit['host_type'] ==$CI->config->item('system_host_type_special'))
                    {
                        $selected_district=$visit['district_id'];
                        if($visit['special_district_id']>0)
                        {
                            $selected_district=$visit['special_district_id'];
                        }
                        ?>
                        <select id="special_district_id" name="visit[special_district_id]" class="form-control">
                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                            <?php
                            foreach($districts as $dis)
                            {?>
                                <option value="<?php echo $dis['value']?>"  <?php if($dis['value']==$selected_district){ echo "selected";}?>><?php echo $dis['text'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <?php
                    }
                    else
                    {
                        ?>
                        <label class="control-label"><?php echo $district['text'];?></label>
                        <?php

                    }
                ?>

            </div>
        </div>
        <div style="<?php if($visit['host_type'] ==$CI->config->item('system_host_type_special')){echo 'display:none';} ?>" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CUSTOMER_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $visit['customer_name'];?></label>
            </div>
        </div>
        <div style="<?php if($visit['host_type'] !=$CI->config->item('system_host_type_special')){echo 'display:none';} ?>" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_TITLE');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input name="visit[title]" type="text" class="form-control" value="<?php echo $visit['title'] ?>">

            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Market Situation</label>
            </div>
            <div class="col-xs-4">
                <textarea name="visit[market_situation]" id="market_situation" class="form-control"><?php echo $visit['market_situation'] ?></textarea>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Payment</label>
            </div>
            <div class="col-xs-4">
                <textarea name="visit[payment]" id="payment" class="form-control"><?php echo $visit['payment'] ?></textarea>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Target</label>
            </div>
            <div class="col-xs-4">
                <textarea name="visit[target]" id="target" class="form-control"><?php echo $visit['target'] ?></textarea>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Special Events</label>
            </div>
            <div class="col-xs-4">
                <textarea name="visit[activities]" id="activities" class="form-control"><?php echo $visit['activities'] ?></textarea>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Activities Picture</label>
            </div>
            <div class="col-xs-4" id="image_activities">
                <?php
                $image=base_url().'images/no_image.jpg';
                if(strlen($visit['picture_url_activities'])>0)
                {
                    $image=$visit['picture_url_activities'];
                }
                ?>
                <img style="max-width: 250px;" src="<?php echo $image;?>">
            </div>
            <div class="col-xs-4">
                <input type="file" class="browse_button" data-preview-container="#image_activities" name="image_activities">
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Problem</label>
            </div>
            <div class="col-xs-4">
                <textarea name="visit[problem]" id="problem" class="form-control"><?php echo $visit['problem'] ?></textarea>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Problem Picture</label>
            </div>
            <div class="col-xs-4" id="image_problem">
                <?php
                $image=base_url().'images/no_image.jpg';
                if(strlen($visit['picture_url_problem'])>0)
                {
                    $image=$visit['picture_url_problem'];
                }
                ?>
                <img style="max-width: 250px;" src="<?php echo $image;?>">
            </div>
            <div class="col-xs-4">
                <input type="file" class="browse_button" data-preview-container="#image_problem" name="image_problem">
            </div>
        </div>
        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Recommendation<span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <textarea name="visit[recommendation]" id="problem" class="form-control"><?php echo $visit['recommendation'] ?></textarea>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</form>
<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".browse_button").filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});

    });
</script>
