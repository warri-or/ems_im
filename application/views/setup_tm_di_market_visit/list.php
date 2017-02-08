<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    if(isset($CI->permissions['add'])&&($CI->permissions['add']==1))
    {
        $action_data["action_new"]=base_url($CI->controller_url."/index/add");
    }
    if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
    {
        $action_data["action_edit"]=base_url($CI->controller_url."/index/edit");
    }
    if(isset($CI->permissions['print'])&&($CI->permissions['print']==1))
    {
        $action_data["action_print"]='print';
    }
    if(isset($CI->permissions['download'])&&($CI->permissions['download']==1))
    {
        $action_data["action_csv"]='csv';
    }
    $action_data["action_refresh"]=base_url($CI->controller_url."/index/list");
    $CI->load->view("action_buttons",$action_data);
?>

<div class="row widget">
    <div class="widget-header">
        <div class="title">
            <?php echo $title; ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php
    if(isset($CI->permissions['column_headers'])&&($CI->permissions['column_headers']==1))
    {

        ?>
        <div class="col-xs-12" style="margin-bottom: 20px;">
            <div class="col-xs-12" style="margin-bottom: 20px;">
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="division_name"><?php echo $CI->lang->line('LABEL_DIVISION_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="date_start"><?php echo $CI->lang->line('LABEL_DATE_START'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="date_end"><?php echo $CI->lang->line('LABEL_DATE_END'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="title"><?php echo $CI->lang->line('LABEL_TITLE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="visit_purpose">Visit Purpose</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="description"><?php echo $CI->lang->line('LABEL_DESCRIPTION'); ?></label>

            </div>
        </div>
    <?php
    }
    ?>
    <div class="col-xs-12" id="system_jqx_container">

    </div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        var url = "<?php echo base_url($CI->controller_url.'/get_items');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'division_name', type: 'string' },
                { name: 'title', type: 'string' },
                { name: 'visit_purpose', type: 'string' },
                { name: 'description', type: 'string' },
                { name: 'date_start', type: 'string' },
                { name: 'date_end', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);
        // create jqxgrid.
        $("#system_jqx_container").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize:50,
                pagesizeoptions: ['20', '50', '100', '200','300','500'],
                selectionmode: 'singlerow',
                altrows: true,
                autoheight: true,
                autorowheight:true,
                columns: [
                    { text: '<?php echo $CI->lang->line('LABEL_DIVISION_NAME'); ?>', dataField: 'division_name',pinned:true,width:'100',filtertype: 'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_DATE_START'); ?>', dataField: 'date_start',width:'100'},
                    { text: '<?php echo $CI->lang->line('LABEL_DATE_END'); ?>', dataField: 'date_end',width:'100'},
                    { text: '<?php echo $CI->lang->line('LABEL_TITLE'); ?>', dataField: 'title',width:'100'},
                    { text: 'Visit Purpose', dataField: 'visit_purpose'},
                    { text: '<?php echo $CI->lang->line('LABEL_DESCRIPTION'); ?>', dataField: 'description'}

                ]
            });
    });
</script>