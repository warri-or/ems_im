<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    $action_data["action_back"]=base_url($CI->controller_url);
    $action_data["action_save"]='#save_form';
    $CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $fsetup['id']; ?>" />
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_YEAR');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $fsetup['year'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_SEASON');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $fsetup['season_name'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_NAME');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $fsetup['crop_name'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_CROP_TYPE');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $fsetup['crop_type_name'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">PRI's Name</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $fsetup['name'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_ADDRESS');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $fsetup['address'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DATE_SOWING');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($fsetup['date_sowing']); ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DATE_TRANSPLANT');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php if($fsetup['date_transplant']>0){echo System_helper::display_date($fsetup['date_transplant']); }?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_NUM_VISITS');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $fsetup['num_visits'];?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_INTERVAL');?></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo $fsetup['interval'];?></label>
            </div>
        </div>

    </div>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle external" data-toggle="collapse"  data-target="#collapse_visits_picture" href="#">Visit Picture and remarks</a>
                </h4>
            </div>
            <div id="collapse_visits_picture" class="panel-collapse collapse in">
                <?php
                for($i=1;$i<=$fsetup['num_visits'];$i++)
                {
                    ?>
                    <div class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE');?></label>
                        </div>
                        <div class="col-xs-4">
                            <label class="form-control" style="background-color: #F5F5F5;"><?php echo System_helper::display_date($fsetup['date_sowing']+24*3600*$i*$fsetup['interval']); ?></label>
                        </div>
                    </div>
                    <div style="overflow-x: auto;" class="row show-grid">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="min-width: 150px;"><?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?></th>
                                <th style="min-width: 250px;">Picture - <?php echo $i;?></th>
                                <th style="min-width: 50px;">UPLOAD</th>
                                <th style="min-width: 150px;"><?php echo $this->lang->line('LABEL_REMARKS');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($previous_varieties as $variety)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $variety['variety_name']; ?></td>
                                    <td>
                                        <?php
                                        $editable=false;
                                        $image=base_url().'images/no_image.jpg';
                                        if(isset($visits_picture[$i][$variety['variety_id']]['picture_url'])&&strlen($visits_picture[$i][$variety['variety_id']]['picture_url'])>0)
                                        {
                                            $image=$visits_picture[$i][$variety['variety_id']]['picture_url'];
                                            if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
                                            {
                                                $editable=true;
                                            }
                                            else
                                            {
                                                $editable=false;
                                            }
                                        }
                                        else
                                        {
                                            $editable=true;
                                        }
                                        ?>
                                        <div class="col-xs-4" id="visit_image_<?php echo $i.'_'.$variety['variety_id']; ?>">
                                            <img style="max-width: 250px;" src="<?php echo $image;?>">
                                        </div>
                                    </td>
                                    <td><?php
                                        if($editable)
                                        {
                                            ?>
                                            <input type="file" class="browse_button" data-preview-container="#visit_image_<?php echo $i.'_'.$variety['variety_id']; ?>" name="visit_image_<?php echo $i.'_'.$variety['variety_id']; ?>">
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $editable=false;
                                        $remarks='';
                                        if(isset($visits_picture[$i][$variety['variety_id']]['remarks'])&&strlen($visits_picture[$i][$variety['variety_id']]['remarks'])>0)
                                        {
                                            $remarks=$visits_picture[$i][$variety['variety_id']]['remarks'];
                                            if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
                                            {
                                                $editable=true;
                                            }
                                            else
                                            {
                                                $editable=false;
                                            }
                                        }
                                        else
                                        {
                                            $editable=true;
                                        }
                                        ?>
                                        <?php
                                        if($editable)
                                        {
                                            ?>
                                            <textarea class="form-control" name="visit_remarks[<?php echo $i; ?>][<?php echo $variety['variety_id']; ?>]"><?php echo $remarks; ?></textarea>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <?php echo $remarks; ?>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle external" data-toggle="collapse"  data-target="#collapse_fruit_picture" href="#">Fruit Picture and remarks</a>
                </h4>
            </div>
            <div id="collapse_fruit_picture" class="panel-collapse collapse">
                <?php
                foreach($fruits_picture_headers as $headers)
                {
                    ?>
                    <div class="row show-grid">
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label"><?php echo $headers['name'];?></label>
                        </div>
                    </div>
                    <div style="overflow-x: auto;" class="row show-grid">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="min-width: 150px;"><?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?></th>
                                <th style="min-width: 250px;">Picture</th>
                                <th style="min-width: 50px;">UPLOAD</th>
                                <th style="min-width: 150px;"><?php echo $this->lang->line('LABEL_REMARKS');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($previous_varieties as $variety)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $variety['variety_name']; ?></td>
                                    <td>
                                        <?php
                                        $editable=false;
                                        $image=base_url().'images/no_image.jpg';
                                        if(isset($fruits_picture[$headers['id']][$variety['variety_id']]['picture_url'])&&strlen($fruits_picture[$headers['id']][$variety['variety_id']]['picture_url'])>0)
                                        {
                                            $image=$fruits_picture[$headers['id']][$variety['variety_id']]['picture_url'];
                                            if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
                                            {
                                                $editable=true;
                                            }
                                            else
                                            {
                                                $editable=false;
                                            }
                                        }
                                        else
                                        {
                                            $editable=true;
                                        }
                                        ?>
                                        <div class="col-xs-4" id="fruit_image_<?php echo $headers['id'].'_'.$variety['variety_id']; ?>">
                                            <img style="max-width: 250px;" src="<?php echo $image;?>">
                                        </div>
                                    </td>
                                    <td><?php
                                        if($editable)
                                        {
                                            ?>
                                            <input type="file" class="browse_button" data-preview-container="#fruit_image_<?php echo $headers['id'].'_'.$variety['variety_id']; ?>" name="fruit_image_<?php echo $headers['id'].'_'.$variety['variety_id']; ?>">
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $editable=false;
                                        $remarks='';
                                        if(isset($fruits_picture[$headers['id']][$variety['variety_id']]['remarks'])&&strlen($fruits_picture[$headers['id']][$variety['variety_id']]['remarks'])>0)
                                        {
                                            $remarks=$fruits_picture[$headers['id']][$variety['variety_id']]['remarks'];
                                            if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
                                            {
                                                $editable=true;
                                            }
                                            else
                                            {
                                                $editable=false;
                                            }
                                        }
                                        else
                                        {
                                            $editable=true;
                                        }
                                        ?>
                                        <?php
                                        if($editable)
                                        {
                                            ?>
                                            <textarea class="form-control" name="fruit_remarks[<?php echo $headers['id']; ?>][<?php echo $variety['variety_id']; ?>]"><?php echo $remarks; ?></textarea>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <?php echo $remarks; ?>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle external" data-toggle="collapse"  data-target="#collapse_disease_picture" href="#">Disease Picture and remarks</a>
                </h4>
            </div>
            <div id="collapse_disease_picture" class="panel-collapse collapse">
                <div id="disease_container">
                    <div style="overflow-x: auto;" class="row show-grid">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="min-width: 150px;"><?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?></th>
                                <th style="min-width: 250px;">Picture</th>
                                <th style="min-width: 50px;">UPLOAD</th>
                                <th style="min-width: 150px;"><?php echo $this->lang->line('LABEL_REMARKS');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($disease_picture as $index=>$disease_info)
                            {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $previous_varieties[$disease_info['variety_id']]['variety_name']; ?>
                                        <input type="hidden" name="disease[<?php echo $index+1; ?>][id]" value="<?php echo $disease_info['id']; ?>">
                                        <input type="hidden" name="disease[<?php echo $index+1; ?>][variety_id]" value="<?php echo $disease_info['variety_id']; ?>">
                                    </td>
                                    <td>
                                        <div class="disease_image_container" id="disease_image_<?php echo $index+1;?>">
                                            <?php
                                            $image=base_url().'images/no_image.jpg';
                                            if(strlen($disease_info['picture_url'])>0)
                                            {
                                                $image=$disease_info['picture_url'];
                                            }
                                            ?>
                                            <img style="max-width: 250px;" src="<?php echo $image;?>">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="file" id="disease_image_<?php echo $index+1; ?>" name="disease_image_<?php echo $index+1; ?>" data-current-id="<?php echo $index+1;?>" data-preview-container="#disease_image_<?php echo $index+1;?>" class="browse_button"><br>
                                        <button type="button" class="btn btn-danger system_button_add_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
                                    </td>
                                    <td>
                                        <textarea id="disease_remarks_<?php echo $index+1;?>" name="disease[<?php echo $index+1; ?>][remarks]" data-current-id="<?php echo $index+1;?>" class="form-control remarks"><?php echo $disease_info['remarks']; ?></textarea>
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
                        <button type="button" class="btn btn-warning system_button_add_more" data-current-id="<?php echo sizeof($disease_picture);?>"><?php echo $CI->lang->line('LABEL_ADD_MORE');?></button>
                    </div>
                    <div class="col-xs-4">

                    </div>
                </div>
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
                <select class="form-control variety">
                    <?php
                    foreach($previous_varieties as $variety)
                    {?>
                        <option value="<?php echo $variety['variety_id']?>"><?php echo $variety['variety_name'];?></option>
                    <?php
                    }
                    ?>
                </select>
                <input type="hidden" class="variety_id" value="0">
            </td>
            <td>
                <div class="disease_image_container"><img style="max-width: 250px;" src="<?php echo base_url().'images/no_image.jpg';?>"></div>
            </td>
            <td>
                <input type="file" class="browse_button_new"><br>
                <button type="button" class="btn btn-danger system_button_add_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
            </td>
            <td>
                <textarea class="form-control remarks"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".browse_button").filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});

        $(document).on("click", ".system_button_add_more", function(event)
        {
            var current_id=parseInt($(this).attr('data-current-id'));
            current_id=current_id+1;
            $(this).attr('data-current-id',current_id);
            var content_id='#system_content_add_more table tbody';


            $(content_id+' .variety_id').attr('name','disease['+current_id+'][id]');
            $(content_id+' .variety').attr('name','disease['+current_id+'][variety_id]');
            $(content_id+' .remarks').attr('name','disease['+current_id+'][remarks]');

            $(content_id+' .browse_button_new').attr('data-preview-container','#disease_image_'+current_id);
            $(content_id+' .browse_button_new').attr('name','disease_image_'+current_id);
            $(content_id+' .browse_button_new').attr('id','disease_browse_'+current_id);
            $(content_id+' .disease_image_container').attr('id','disease_image_'+current_id);

            var html=$(content_id).html();
            $("#disease_container tbody").append(html);

            $(content_id+' .variety').removeAttr('name');
            $(content_id+' .variety').removeAttr('name');
            $(content_id+' .remarks').removeAttr('name');
            $(content_id+' .browse_button_new').removeAttr('name');
            $(content_id+' .browse_button_new').removeAttr('data-preview-container');
            $(content_id+' .browse_button_new').removeAttr('id');
            $(content_id+' .disease_image_container').removeAttr('id');
            $('#disease_browse_'+current_id).filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});

        });
        $(document).on("click", ".system_button_add_delete", function(event)
        {
            $(this).closest('tr').remove();
        });

    });
</script>
