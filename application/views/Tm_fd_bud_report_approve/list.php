<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();

if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
{
    $action_data["action_edit"]=base_url($CI->controller_url."/index/edit");
}
if(isset($CI->permissions['report_approve'])&&($CI->permissions['report_approve']==1))
{
    $action_data["action_fdr_approve"]=base_url($CI->controller_url."/index/approve");
}
if(isset($CI->permissions['view'])&&($CI->permissions['view']==1))
{
    $action_data["action_details"]=base_url($CI->controller_url."/index/details");
}
if(isset($CI->permissions['print'])&&($CI->permissions['print']==1))
{
    $action_data["action_print"]='FIELD DAY BUDGET LIST';
}
if(isset($CI->permissions['download'])&&($CI->permissions['download']==1))
{
    $action_data["action_csv"]='FIELD DAY BUDGET LIST';
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
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="date"><?php echo $CI->lang->line('LABEL_DATE'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="expected_date"><?php echo $CI->lang->line('LABEL_EXPECTED_DATE'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="total_budget"><?php echo $CI->lang->line('LABEL_TOTAL_BUDGET'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="crop_name"><?php echo $CI->lang->line('LABEL_CROP_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="crop_type_name"><?php echo $CI->lang->line('LABEL_CROP_TYPE'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="variety_name"><?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="com_variety_name"><?php echo $CI->lang->line('LABEL_COMPETITOR_VARIETY'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  value="division_name"><?php echo $CI->lang->line('LABEL_DIVISION_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  value="zone_name"><?php echo $CI->lang->line('LABEL_ZONE_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  value="territory_name"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="district_name"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="upazilla_name"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="status_reporting"><?php echo $CI->lang->line('LABEL_REPORTING'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="status_report_approved"><?php echo $CI->lang->line('LABEL_APPROVAL'); ?></label>


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
        var url = "<?php echo base_url($CI->controller_url.'/index/get_items');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'date', type: 'string' },
                { name: 'expected_date', type: 'string' },
                { name: 'total_budget', type: 'string' },
                { name: 'crop_name', type: 'string' },
                { name: 'crop_type_name', type: 'string' },
                { name: 'variety_name', type: 'string' },
                { name: 'com_variety_name', type: 'string' },
                { name: 'division_name', type: 'string' },
                { name: 'zone_name', type: 'string' },
                { name: 'territory_name', type: 'string' },
                { name: 'district_name', type: 'string' },
                { name: 'upazilla_name', type: 'string' },
                { name: 'status_report_approved', type: 'string' },
                { name: 'status_reporting', type: 'string' }

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
                autorowheight: true,
                columnsreorder: true,
                columns: [
                    {
                        text: '<?php echo $CI->lang->line('LABEL_SL_NO'); ?>',datafield: '',pinned:true,width:'80', columntype: 'number',cellsalign: 'right',sortable:false,filterable:false,
                        cellsrenderer: function(row, column, value, defaultHtml, columnSettings, record)
                        {
                            var element = $(defaultHtml);
                            element.html(value+1);
                            return element[0].outerHTML;
                        }
                    },
                    { text: '<?php echo $CI->lang->line('LABEL_DATE'); ?>', dataField: 'date',width:'120',cellsalign: 'right',pinned:true},
                    { text: '<?php echo $CI->lang->line('LABEL_EXPECTED_DATE'); ?>', dataField: 'expected_date',width:'120',cellsalign: 'right',pinned:true},
                    { text: '<?php echo $CI->lang->line('LABEL_TOTAL_BUDGET'); ?>', dataField: 'total_budget',width:'130',cellsalign: 'right',pinned:true},
                    { text: '<?php echo $CI->lang->line('LABEL_CROP_NAME'); ?>', dataField: 'crop_name',width:'120',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('LABEL_CROP_TYPE'); ?>', dataField: 'crop_type_name',filtertype: 'list',width:'120',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?>', dataField: 'variety_name',width:'130',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('LABEL_COMPETITOR_VARIETY'); ?>', dataField: 'com_variety_name',width:'140',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('LABEL_DIVISION_NAME'); ?>', dataField: 'division_name',width:'100',cellsalign: 'right',hidden: true},
                    { text: '<?php echo $CI->lang->line('LABEL_ZONE_NAME'); ?>', dataField: 'zone_name',width:'100',cellsalign: 'right',hidden: true},
                    { text: '<?php echo $CI->lang->line('LABEL_TERRITORY_NAME'); ?>', dataField: 'territory_name',width:'100',cellsalign: 'right',hidden: true},
                    { text: '<?php echo $CI->lang->line('LABEL_DISTRICT_NAME'); ?>', dataField: 'district_name',width:'130',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('LABEL_UPAZILLA_NAME'); ?>', dataField: 'upazilla_name',width:'130',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('LABEL_REPORTING'); ?>', dataField: 'status_reporting',width:'100',cellsalign: 'right',filtertype: 'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_APPROVAL'); ?>', dataField: 'status_report_approved',width:'100',cellsalign: 'right',filtertype: 'list'}

                ]
            });
        //var listSource = [{ label: 'Name', value: 'name', checked: false }, { label: 'Beverage Type', value: 'type', checked: true }, { label: 'Calories', value: 'calories', checked: true }, { label: 'Total Fat', value: 'totalfat', checked: true }, { label: 'Protein', value: 'protein', checked: true}];

        //$("#jqxlistbox").jqxListBox({ source: listSource,   checkboxes: true });

    });
</script>