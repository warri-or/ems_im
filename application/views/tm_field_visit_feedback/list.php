<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();

    $action_data=array();
    if((isset($CI->permissions['add'])&&($CI->permissions['add']==1))||(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1)))
    {
        $action_data["action_edit"]=base_url($CI->controller_url."/index/edit");
    }
    if(isset($CI->permissions['view'])&&($CI->permissions['view']==1))
    {
        $action_data["action_details"]=base_url($CI->controller_url."/index/details");
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
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="name">Farmer Name</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="year"><?php echo $CI->lang->line('LABEL_YEAR'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="season_name"><?php echo $CI->lang->line('LABEL_SEASON'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="division_name"><?php echo $CI->lang->line('LABEL_DIVISION_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="zone_name"><?php echo $CI->lang->line('LABEL_ZONE_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="territory_name"><?php echo $CI->lang->line('LABEL_TERRITORY_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="district_name"><?php echo $CI->lang->line('LABEL_DISTRICT_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="upazilla_name"><?php echo $CI->lang->line('LABEL_UPAZILLA_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="contact_no">Contact No</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="date_sowing"><?php echo $CI->lang->line('LABEL_DATE_SOWING'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_visits"><?php echo $CI->lang->line('LABEL_NUM_VISITS'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="interval"><?php echo $CI->lang->line('LABEL_INTERVAL'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="feedback_require">Feedback Require</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_visit_done">visit done</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_visit_done_feedback">visit feedback</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_fruit_picture">Fruit Picture</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_fruit_picture_feedback">Fruit Picture Feedback</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_disease_picture">Disease</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="num_disease_picture_feedback">Disease feedback</label>
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
        var url = "<?php echo base_url($CI->controller_url.'/index/get_items');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'name', type: 'string' },
                { name: 'year', type: 'string' },
                { name: 'season_name', type: 'string' },
                { name: 'division_name', type: 'string' },
                { name: 'zone_name', type: 'string' },
                { name: 'territory_name', type: 'string' },
                { name: 'district_name', type: 'string' },
                { name: 'upazilla_name', type: 'string' },
                { name: 'contact_no', type: 'string' },
                { name: 'date_sowing', type: 'string' },
                { name: 'num_visits', type: 'string' },
                { name: 'interval', type: 'string' },
                { name: 'feedback_require', type: 'string' },
                { name: 'num_visit_done', type: 'string' },
                { name: 'num_visit_done_feedback', type: 'string' },
                { name: 'num_fruit_picture', type: 'string' },
                { name: 'num_fruit_picture_feedback', type: 'string' },
                { name: 'num_disease_picture', type: 'string' },
                { name: 'num_disease_picture_feedback', type: 'string' }

            ],
            id: 'id',
            url: url
        };
        var cellsrenderer = function(row, column, value, defaultHtml, columnSettings, record)
        {
            var element = $(defaultHtml);
            // console.log(defaultHtml);

            /*if ((record.num_visit_done!=record.num_visit_done_feedback)||(record.num_fruit_picture!=record.num_fruit_picture_feedback)||(record.num_disease_picture!=record.num_disease_picture_feedback))
            {
                element.css({ 'background-color': '#FF0000','margin': '0px','width': '100%', 'height': '100%',padding:'5px','line-height':'25px'});
            }*/
            if ((record.feedback_require=='Yes')&& (column!="name"))
            {
                element.css({ 'background-color': '#FF0000','margin': '0px','width': '100%', 'height': '100%',padding:'5px','line-height':'25px'});
            }
            else
            {
                element.css({'margin': '0px','width': '100%', 'height': '100%',padding:'5px','line-height':'25px'});
            }
            return element[0].outerHTML;

        };
        var tooltiprenderer = function (element) {
            $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
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
                enabletooltips: true,
                rowsheight: 35,
                columns: [
                    { text: 'Farmer Name', dataField: 'name',width:'200',pinned:true,cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_YEAR'); ?>', dataField: 'year',width:'80',filtertype: 'list',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_SEASON'); ?>', dataField: 'season_name',width:'80',filtertype: 'list',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_DIVISION_NAME'); ?>', dataField: 'division_name',width:'100',filtertype: 'list',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_ZONE_NAME'); ?>', dataField: 'zone_name',width:'100',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_TERRITORY_NAME'); ?>', dataField: 'territory_name',width:'100',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_DISTRICT_NAME'); ?>', dataField: 'district_name',width:'100',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_UPAZILLA_NAME'); ?>', dataField: 'upazilla_name',width:'100',cellsrenderer: cellsrenderer},
                    { text: 'Contact No', dataField: 'contact_no',width:'150',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_DATE_SOWING'); ?>', dataField: 'date_sowing',width:'110',cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_NUM_VISITS'); ?>', dataField: 'num_visits',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_INTERVAL'); ?>', dataField: 'interval',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: 'Feedback Require',datafield: 'feedback_require',width:'100', cellsalign: 'right',filtertype: 'list',cellsrenderer: cellsrenderer},
                    { text: 'visit done', dataField: 'num_visit_done',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: 'visit feedback', dataField: 'num_visit_done_feedback',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: 'Fruit Picture', dataField: 'num_fruit_picture',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: 'Fruit Picture Feedback', dataField: 'num_fruit_picture_feedback',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: 'Disease', dataField: 'num_disease_picture',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer},
                    { text: 'Disease Feedback', dataField: 'num_disease_picture_feedback',width:'50',cellsalign: 'right',rendered: tooltiprenderer,cellsrenderer: cellsrenderer}
                ]
            });
    });
</script>