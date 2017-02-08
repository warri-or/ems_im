<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
    {
        $action_data["action_edit"]=base_url($CI->controller_url."/index/edit");
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
                { name: 'employee_id', type: 'string' },
                { name: 'designation_name', type: 'string' },
                { name: 'user_name', type: 'string' },
                { name: 'group_name', type: 'string' },
                { name: 'name', type: 'string' },
                { name: 'ordering', type: 'int' }
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
                columns: [
                    { text: '<?php echo $CI->lang->line('LABEL_EMPLOYEE_ID'); ?>', dataField: 'employee_id',width:'100'},
                    { text: '<?php echo $CI->lang->line('LABEL_USERNAME'); ?>', dataField: 'user_name',width:'150'},
                    { text: '<?php echo $CI->lang->line('LABEL_NAME'); ?>', dataField: 'name',width:'300'},
                    { text: '<?php echo $CI->lang->line('LABEL_DESIGNATION_NAME'); ?>', dataField: 'designation_name',width:'200'},
                    { text: '<?php echo $CI->lang->line('LABEL_USER_GROUP'); ?>', dataField: 'group_name'},
                    { text: '<?php echo $CI->lang->line('LABEL_ORDER'); ?>', dataField: 'ordering',width:'150',cellsalign: 'right'}
                ]
            });
    });
</script>