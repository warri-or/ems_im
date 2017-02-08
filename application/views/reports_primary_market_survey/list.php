<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $CI = & get_instance();
    $action_data=array();
    if(isset($CI->permissions['print'])&&($CI->permissions['print']==1))
    {
        $action_data["action_print"]='print';
    }
    if(isset($CI->permissions['download'])&&($CI->permissions['download']==1))
    {
        $action_data["action_csv"]='csv';
    }
    if(sizeof($action_data)>0)
    {
        $CI->load->view("action_buttons",$action_data);
    }

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
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="crop_name"><?php echo $CI->lang->line('LABEL_CROP_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="crop_type_name"><?php echo $CI->lang->line('LABEL_CROP_TYPE'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="variety_name"><?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?></label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="weight_assumed">Assumed Market Size</label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="weight_final">ZI Assumed Market Size</label>
            <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column"  checked value="unions">Unions</label>
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
        //var grand_total_color='#AEC2DD';
        var grand_total_color='#AEC2DD';

        var url = "<?php echo base_url($CI->controller_url.'/get_items');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'crop_name', type: 'string' },
                { name: 'crop_type_name', type: 'string' },
                { name: 'variety_name', type: 'string' },
                <?php
                    for($i=1;$i<=$max_customers_number;$i++)
                    {?>{ name: '<?php echo 'weight_sales_'.$i;?>', type: 'string' },
                { name: '<?php echo 'weight_market_'.$i;?>', type: 'string' },
                <?php
                    }
                ?>

                { name: 'weight_assumed', type: 'string' },
                { name: 'weight_final', type: 'string' },
                { name: 'unions', type: 'string' }

            ],
            id: 'id',
            url: url,
            type: 'POST',
            data:{<?php echo $keys; ?>}
        };
        var cellsrenderer = function(row, column, value, defaultHtml, columnSettings, record)
        {
            var element = $(defaultHtml);
           // console.log(defaultHtml);

            if (record.variety_name=="ARM Variety")
            {
                element.css({ 'background-color': '#6CAB44','margin': '0px','width': '100%', 'height': '100%',padding:'5px','line-height':'25px'});
            }
            else if (record.variety_name=="Competitor Variety")
            {
                element.css({ 'background-color': '#0CA2C5','margin': '0px','width': '100%', 'height': '100%',padding:'5px','line-height':'25px'});

            }
            else if (record.variety_name=="Others variety")
            {

                element.css({ 'background-color': grand_total_color,'margin': '0px','width': '100%', 'height': '100%',padding:'5px','line-height':'25px'});

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
                height:'350px',
                source: dataAdapter,
                columnsresize: true,
                columnsreorder: true,
                altrows: true,
                enabletooltips: true,
                rowsheight: 35,
                columns: [
                    { text: '<?php echo $CI->lang->line('LABEL_CROP_NAME'); ?>', dataField: 'crop_name',width: '100',cellsrenderer: cellsrenderer,pinned:true,rendered: tooltiprenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_CROP_TYPE'); ?>', dataField: 'crop_type_name',width: '100',cellsrenderer: cellsrenderer,pinned:true,rendered: tooltiprenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_VARIETY_NAME'); ?>', dataField: 'variety_name',width: '150',cellsrenderer: cellsrenderer,pinned:true,rendered: tooltiprenderer},
                        <?php
                            for($i=1;$i<=$max_customers_number;$i++)
                            {?>{ columngroup: '<?php echo $i; ?>',text: 'Individual Sales Quantity', dataField: '<?php echo 'weight_sales_'.$i;?>',align:'center',cellsalign: 'right',width:'150',cellsrenderer: cellsrenderer,rendered: tooltiprenderer},
                    { columngroup: '<?php echo $i; ?>',text: 'Market Size', dataField: '<?php echo 'weight_market_'.$i;?>',align:'center',cellsalign: 'right',width:'150',cellsrenderer: cellsrenderer,rendered: tooltiprenderer},
                    <?php
                        }
                    ?>
                    { text: 'Assumed Market Size', dataField: 'weight_assumed',align:'center',cellsalign: 'right',width:'150',cellsrenderer: cellsrenderer,rendered: tooltiprenderer},
                    { text: 'ZI Assumed Market Size', dataField: 'weight_final',align:'center',cellsalign: 'right',width:'150',cellsrenderer: cellsrenderer,rendered: tooltiprenderer},
                    { text: 'Unions', dataField: 'unions',align:'center',width:'300',cellsrenderer: cellsrenderer,rendered: tooltiprenderer}

                ],
                columngroups:
                    [
                            <?php
                                for($i=1;$i<=$max_customers_number;$i++)
                                {?>{ text: '<?php if(isset($customers[$i]['name'])){echo $customers[$i]['name'];} ?>', align: 'center', name: '<?php echo $i; ?>' },
                        <?php
                            }
                        ?>
                    ]
            });
    });
</script>