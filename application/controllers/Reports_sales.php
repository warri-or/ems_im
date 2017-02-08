<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_sales extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Reports_sales');
        $this->locations=User_helper::get_locations();
        if(!is_array($this->locations))
        {
            if($this->locations=='wrong')
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('MSG_LOCATION_INVALID');
                $this->jsonReturn($ajax);
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('MSG_LOCATION_NOT_ASSIGNED');
                $this->jsonReturn($ajax);
            }

        }
        $this->controller_url='reports_sales';
    }

    public function index($action="search",$id=0)
    {
        if($action=="search")
        {
            $this->system_search();
        }
        elseif($action=="list")
        {
            $this->system_list();
        }
        else
        {
            $this->system_search();
        }
    }
    private function system_search()
    {
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            $data['title']="Search Sales";
            $ajax['status']=true;
            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['zones']=array();
            $data['territories']=array();
            $data['districts']=array();
            $data['customers']=array();
            if($this->locations['division_id']>0)
            {
                $data['zones']=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('division_id ='.$this->locations['division_id']));
                if($this->locations['zone_id']>0)
                {
                    $data['territories']=Query_helper::get_info($this->config->item('table_setup_location_territories'),array('id value','name text'),array('zone_id ='.$this->locations['zone_id']));
                    if($this->locations['territory_id']>0)
                    {
                        $data['districts']=Query_helper::get_info($this->config->item('table_setup_location_districts'),array('id value','name text'),array('territory_id ='.$this->locations['territory_id']));
                        if($this->locations['district_id']>0)
                        {
                            $data['customers']=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','name text'),array('district_id ='.$this->locations['district_id'],'status ="'.$this->config->item('system_status_active').'"'));
                        }
                    }
                }
            }
            $data['warehouses']=Query_helper::get_info($this->config->item('table_basic_setup_warehouse'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['crops']=Query_helper::get_info($this->config->item('table_setup_classification_crops'),array('id value','name text'),array());
            $data['pack_sizes']=Query_helper::get_info($this->config->item('table_setup_classification_vpack_size'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('name ASC'));
            $fiscal_years=Query_helper::get_info($this->config->item('table_basic_setup_fiscal_year'),'*',array());
            $data['fiscal_years']=array();
            foreach($fiscal_years as $year)
            {
                $data['fiscal_years'][]=array('text'=>$year['name'],'value'=>System_helper::display_date($year['date_start']).'/'.System_helper::display_date($year['date_end']));
            }
            $data['date_start']='';
            $data['date_end']=System_helper::display_date(time());

            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("reports_sales/search",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }

    }

    private function system_list()
    {


        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            $reports=$this->input->post('report');
            $reports['date_end']=System_helper::get_time($reports['date_end']);
            $reports['date_start']=System_helper::get_time($reports['date_start']);
            if($reports['date_end']>0)
            {
                $reports['date_end']=$reports['date_end']+3600*24-1;
            }

            $keys=',';

            foreach($reports as $elem=>$value)
            {
                $keys.=$elem.":'".$value."',";
            }

            $data['keys']=trim($keys,',');


            $ajax['status']=true;
            if($reports['report_name']=='sales_product')
            {
                $data['title']="Product wise Sales Report";
                $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view("reports_sales/list_sales_product",$data,true));
            }
            elseif($reports['report_name']=='sales_customer')
            {
                $data['title']="Customer wise Sales Report";
                $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view("reports_sales/list_sales_customer",$data,true));
            }
            elseif($reports['report_name']=='po')
            {
                $data['title']="Approved Purchase Orders";
                $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view("reports_sales/list_po",$data,true));
            }

            elseif($reports['report_name']=='sales_area')
            {
                $data['title']="Sales Report";
                if($reports['customer_id']>0)
                {

                    $data['areas']=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','name text'),array('id ='.$reports['customer_id']));
                    $data['title'].='(Customer)';
                }
                elseif($reports['district_id']>0)
                {

                    $data['areas']=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','name text'),array('district_id ='.$reports['district_id']));
                    $data['title'].='(Customers)';
                }
                elseif($reports['territory_id']>0)
                {
                    $data['areas']=Query_helper::get_info($this->config->item('table_setup_location_districts'),array('id value','name text'),array('territory_id ='.$reports['territory_id']));
                    $data['title'].='(Districts)';
                }
                elseif($reports['zone_id']>0)
                {
                    $data['areas']=Query_helper::get_info($this->config->item('table_setup_location_territories'),array('id value','name text'),array('zone_id ='.$reports['zone_id']));
                    $data['title'].='(Territories)';
                }
                elseif($reports['division_id']>0)
                {
                    $data['areas']=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('division_id ='.$reports['division_id']));
                    $data['title'].='(Zones)';
                }
                else
                {
                    $data['areas']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
                    $data['title'].='(Divisions)';
                }
                $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view("reports_sales/list_sales_area",$data,true));
            }
            elseif($reports['report_name']=='sales_return')
            {
                $data['title']="Sales Return Report";
                $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view("reports_sales/list_sales_return",$data,true));
            }
            else
            {
                $data['title']="Approved Purchase Orders";
                $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view("reports_sales/list_po",$data,true));
            }


            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }

    }

    public function get_items_sales_customer()
    {
        $items=array();
        $division_id=$this->input->post('division_id');
        $zone_id=$this->input->post('zone_id');
        $territory_id=$this->input->post('territory_id');
        $district_id=$this->input->post('district_id');
        $customer_id=$this->input->post('customer_id');

        $report_type=$this->input->post('report_type');//means kg/pkt

        $warehouse_id=$this->input->post('warehouse_id');
        $crop_id=$this->input->post('crop_id');
        $crop_type_id=$this->input->post('crop_type_id');
        $variety_id=$this->input->post('variety_id');
        $pack_size_id=$this->input->post('pack_size_id');
        $date_end=$this->input->post('date_end');
        $date_start=$this->input->post('date_start');

        $po_no=$this->input->post('po_no');
        if($po_no)
        {
            $po_no=intval($po_no);
            if(!($po_no>0))
            {
                $this->jsonReturn($items);
            }
        }
        $this->db->from($this->config->item('table_sales_po_details').' pod');

        $this->db->select('pod.*');

        $this->db->select('cus.id customer_id');
        $this->db->select('CONCAT(cus.customer_code," - ",cus.name) name');
        $this->db->select('d.name district_name');
        $this->db->select('t.name territory_name');
        $this->db->select('zone.name zone_name');
        $this->db->select('division.name division_name');
        $this->db->select('v.name variety_name');
        $this->db->select('crop_type.name crop_type_name');
        $this->db->select('crop.name crop_name');

        $this->db->join($this->config->item('table_sales_po').' po','po.id = pod.sales_po_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = po.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id =pod.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id =v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id =crop_type.crop_id','INNER');

        $this->db->where('pod.revision',1);
        $this->db->where('po.status_approved',$this->config->item('system_status_po_approval_approved'));


        if($po_no>0)
        {
            $this->db->where('po.id',$po_no);
        }
        else
        {
            if($date_end>0)
            {
                $this->db->where('po.date_approved <=',$date_end);
            }
            if($date_start>0)
            {
                $this->db->where('po.date_approved >=',$date_start);
            }
            if($warehouse_id>0)
            {
                $this->db->where('po.warehouse_id',$warehouse_id);
            }
            if($crop_id>0)
            {
                $this->db->where('crop.id',$crop_id);
            }
            if($crop_type_id>0)
            {
                $this->db->where('crop_type.id',$crop_type_id);
            }
            if($variety_id>0)
            {
                $this->db->where('pod.variety_id',$variety_id);
            }
            if($pack_size_id>0)
            {
                $this->db->where('pod.pack_size_id',$pack_size_id);
            }
            if($division_id>0)
            {
                $this->db->where('division.id',$division_id);
                if($zone_id>0)
                {
                    $this->db->where('zone.id',$zone_id);
                    if($territory_id>0)
                    {
                        $this->db->where('t.id',$territory_id);
                        if($district_id>0)
                        {
                            $this->db->where('d.id',$district_id);
                            if($customer_id>0)
                            {
                                $this->db->where('cus.id',$customer_id);
                            }
                        }
                    }
                }
            }
        }
        $this->db->order_by('cus.ordering','ASC');
        $this->db->order_by('po.id,crop.ordering,crop.id,crop_type.ordering,crop_type.id,v.ordering,v.id');
        $results=$this->db->get()->result_array();
        if(!$results)
        {
            $this->jsonReturn($items);
        }
        $varieties=array();
        foreach($results as $result)
        {
            $is_returned=$this->get_return_validity($date_start,$date_end,$result['date_return']);
            if(isset($varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]))
            {
                //$info['total_po_quantity']=$info['po_quantity']=$info['actual_quantity']=$result['quantity'];
                $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['total_po_quantity']+=$result['quantity'];
                $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['po_quantity']+=$result['quantity'];
                $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['actual_quantity']+=$result['quantity'];

                //$info['po_price']=$info['actual_price']=$result['quantity']*$result['variety_price'];
                $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['po_price']+=($result['quantity']*$result['variety_price']);
                $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['actual_price']+=($result['quantity']*$result['variety_price']);
                $info['return_quantity']=0;
                $info['bonus_quantity']=0;
                $info['bonus_return_quantity']=0;
                if($is_returned)
                {
                    $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['return_quantity']+=$result['quantity_return'];
                    $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['total_po_quantity']-=$result['quantity_return'];
                    $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['actual_quantity']-=$result['quantity_return'];
                    $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]['actual_price']-=($result['quantity_return']*$result['variety_price']);
                }

            }
            else
            {
                $info=array();
                $info['name']=$result['name'];
                $info['division_name']=$result['division_name'];
                $info['zone_name']=$result['zone_name'];
                $info['territory_name']=$result['territory_name'];
                $info['district_name']=$result['district_name'];
                $info['crop_name']=$result['crop_name'];
                $info['crop_type_name']=$result['crop_type_name'];
                $info['variety_name']=$result['variety_name'];
                $info['pack_size']=$result['pack_size'];
                $info['total_po_quantity']=$info['po_quantity']=$info['actual_quantity']=$result['quantity'];
                $info['po_price']=$info['actual_price']=$result['quantity']*$result['variety_price'];
                $info['return_quantity']=0;
                $info['bonus_quantity']=0;
                $info['bonus_return_quantity']=0;
                if($is_returned)
                {
                    $info['return_quantity']+=$result['quantity_return'];
                    $info['total_po_quantity']-=$result['quantity_return'];
                    $info['actual_quantity']-=$result['quantity_return'];
                    $info['actual_price']-=($result['quantity_return']*$result['variety_price']);
                }
                $varieties[$result['customer_id']][$result['variety_id']][$result['pack_size_id']]=$info;
            }
            if($result['bonus_pack_size_id']>0)
            {
                if(isset($varieties[$result['customer_id']][$result['variety_id']][$result['bonus_pack_size_id']]))
                {
                    $varieties[$result['customer_id']][$result['variety_id']][$result['bonus_pack_size_id']]['bonus_quantity']+=$result['quantity_bonus'];
                    $varieties[$result['customer_id']][$result['variety_id']][$result['bonus_pack_size_id']]['total_po_quantity']+=$result['quantity_bonus'];
                    if($is_returned)
                    {
                        $varieties[$result['customer_id']][$result['variety_id']][$result['bonus_pack_size_id']]['total_po_quantity']-=$result['quantity_bonus_return'];
                        $varieties[$result['customer_id']][$result['variety_id']][$result['bonus_pack_size_id']]['bonus_return_quantity']+=$result['quantity_bonus_return'];

                    }

                }
                else
                {
                    $info=array();
                    $info['name']=$result['name'];
                    $info['division_name']=$result['division_name'];
                    $info['zone_name']=$result['zone_name'];
                    $info['territory_name']=$result['territory_name'];
                    $info['district_name']=$result['district_name'];
                    $info['crop_name']=$result['crop_name'];
                    $info['crop_type_name']=$result['crop_type_name'];
                    $info['variety_name']=$result['variety_name'];
                    $info['pack_size']=$result['bonus_pack_size'];
                    $info['total_po_quantity']=$info['po_quantity']=$info['actual_quantity']=0;
                    $info['po_price']=$info['actual_price']=0;
                    $info['return_quantity']=0;
                    $info['bonus_quantity']=$result['quantity_bonus'];
                    $info['total_po_quantity']+=$result['quantity_bonus'];
                    $info['bonus_return_quantity']=0;
                    if($is_returned)
                    {
                        $info['total_po_quantity']-=$result['quantity_bonus_return'];
                        $info['bonus_return_quantity']+=$result['quantity_bonus_return'];

                    }
                    $varieties[$result['customer_id']][$result['variety_id']][$result['bonus_pack_size_id']]=$info;
                }
            }


        }
        /*{ name: 'id', type: 'int' },
                { name: 'name', type: 'string' },
                { name: 'division_name', type: 'numeric' },
                { name: 'zone_name', type: 'string' },
                { name: 'territory_name', type: 'string' },
                { name: 'district_name', type: 'string' },
                { name: 'crop_name', type: 'string' },
                { name: 'crop_type_name', type: 'string' },
                { name: 'variety_name', type: 'string' },
                { name: 'pack_size', type: 'string' },
                { name: 'po_quantity', type: 'string' },
                { name: 'bonus_quantity', type: 'string' },
                { name: 'return_quantity', type: 'string' },
                { name: 'bonus_return_quantity', type: 'string' },
                { name: 'total_po_quantity', type: 'string' },
                { name: 'actual_quantity', type: 'string' },
                { name: 'po_price', type: 'string' },
                { name: 'actual_price', type: 'string' }*/
        $po_quantity_crop=0;
        $po_quantity_customer=0;
        $po_quantity_grand=0;
        $bonus_quantity_crop=0;
        $bonus_quantity_customer=0;
        $bonus_quantity_grand=0;
        $return_quantity_crop=0;
        $return_quantity_customer=0;
        $return_quantity_grand=0;
        $bonus_return_quantity_crop=0;
        $bonus_return_quantity_customer=0;
        $bonus_return_quantity_grand=0;
        $total_po_quantity_crop=0;
        $total_po_quantity_customer=0;
        $total_po_quantity_grand=0;
        $actual_quantity_crop=0;
        $actual_quantity_customer=0;
        $actual_quantity_grand=0;
        $po_price_crop=0;
        $po_price_customer=0;
        $po_price_grand=0;
        $actual_price_crop=0;
        $actual_price_customer=0;
        $actual_price_grand=0;


        $prev_crop_name='';
        $prev_crop_type_name='';
        $prev_variety_name='';
        foreach($varieties as $customers)
        {
            $i=0;
            foreach($customers as $variety)
            {
                foreach($variety as $pack)
                {
                    if($i!=0)
                    {
                        $pack['name']='';
                        $pack['division_name']='';
                        $pack['zone_name']='';
                        $pack['territory_name']='';
                        $pack['district_name']='';
                        if($prev_crop_name!=$pack['crop_name'])
                        {
                            $prev_crop_name=$pack['crop_name'];
                            $prev_crop_type_name=$pack['crop_type_name'];
                            $prev_variety_name=$pack['variety_name'];
                            $items[]=$this->get_total_sales_customer_row('crop',$report_type,$po_quantity_crop,$bonus_quantity_crop,$return_quantity_crop,$bonus_return_quantity_crop,$total_po_quantity_crop,$actual_quantity_crop,$po_price_crop,$actual_price_crop);

                            $po_quantity_crop=0;
                            $bonus_quantity_crop=0;
                            $return_quantity_crop=0;
                            $bonus_return_quantity_crop=0;
                            $total_po_quantity_crop=0;
                            $actual_quantity_crop=0;
                            $po_price_crop=0;
                            $actual_price_crop=0;

                        }
                        elseif($prev_crop_type_name!=$pack['crop_type_name'])
                        {
                            $prev_crop_type_name=$pack['crop_type_name'];
                            $prev_variety_name=$pack['variety_name'];

                            $pack['crop_name']='';

                        }
                        elseif($prev_variety_name!=$pack['variety_name'])
                        {
                            $prev_variety_name=$pack['variety_name'];
                            $pack['crop_name']='';
                            $pack['crop_type_name']='';

                        }
                        else
                        {
                            $pack['crop_name']='';
                            $pack['crop_type_name']='';
                            $pack['variety_name']='';

                        }
                    }
                    else
                    {
                        $prev_crop_name=$pack['crop_name'];
                        $prev_crop_type_name=$pack['crop_type_name'];
                        $prev_variety_name=$pack['variety_name'];

                    }
                    if($report_type=='weight')
                    {
                        $po_quantity_crop+=$pack['po_quantity']*$pack['pack_size'];
                        $po_quantity_customer+=$pack['po_quantity']*$pack['pack_size'];
                        $po_quantity_grand+=$pack['po_quantity']*$pack['pack_size'];
                        $bonus_quantity_crop+=$pack['bonus_quantity']*$pack['pack_size'];
                        $bonus_quantity_customer+=$pack['bonus_quantity']*$pack['pack_size'];
                        $bonus_quantity_grand+=$pack['bonus_quantity']*$pack['pack_size'];
                        $return_quantity_crop+=$pack['return_quantity']*$pack['pack_size'];
                        $return_quantity_customer+=$pack['return_quantity']*$pack['pack_size'];
                        $return_quantity_grand+=$pack['return_quantity']*$pack['pack_size'];
                        $bonus_return_quantity_crop+=$pack['bonus_return_quantity']*$pack['pack_size'];
                        $bonus_return_quantity_customer+=$pack['bonus_return_quantity']*$pack['pack_size'];
                        $bonus_return_quantity_grand+=$pack['bonus_return_quantity']*$pack['pack_size'];
                        $total_po_quantity_crop+=$pack['total_po_quantity']*$pack['pack_size'];
                        $total_po_quantity_customer+=$pack['total_po_quantity']*$pack['pack_size'];
                        $total_po_quantity_grand+=$pack['total_po_quantity']*$pack['pack_size'];
                        $actual_quantity_crop+=$pack['actual_quantity']*$pack['pack_size'];
                        $actual_quantity_customer+=$pack['actual_quantity']*$pack['pack_size'];
                        $actual_quantity_grand+=$pack['actual_quantity']*$pack['pack_size'];
                    }
                    else
                    {
                        $po_quantity_crop+=$pack['po_quantity'];
                        $po_quantity_customer+=$pack['po_quantity'];
                        $po_quantity_grand+=$pack['po_quantity'];
                        $bonus_quantity_crop+=$pack['bonus_quantity'];
                        $bonus_quantity_customer+=$pack['bonus_quantity'];
                        $bonus_quantity_grand+=$pack['bonus_quantity'];
                        $return_quantity_crop+=$pack['return_quantity'];
                        $return_quantity_customer+=$pack['return_quantity'];
                        $return_quantity_grand+=$pack['return_quantity'];
                        $bonus_return_quantity_crop+=$pack['bonus_return_quantity'];
                        $bonus_return_quantity_customer+=$pack['bonus_return_quantity'];
                        $bonus_return_quantity_grand+=$pack['bonus_return_quantity'];
                        $total_po_quantity_crop+=$pack['total_po_quantity'];
                        $total_po_quantity_customer+=$pack['total_po_quantity'];
                        $total_po_quantity_grand+=$pack['total_po_quantity'];
                        $actual_quantity_crop+=$pack['actual_quantity'];
                        $actual_quantity_customer+=$pack['actual_quantity'];
                        $actual_quantity_grand+=$pack['actual_quantity'];

                    }
                    $po_price_crop+=$pack['po_price'];
                    $po_price_customer+=$pack['po_price'];
                    $po_price_grand+=$pack['po_price'];
                    $actual_price_crop+=$pack['actual_price'];
                    $actual_price_customer+=$pack['actual_price'];
                    $actual_price_grand+=$pack['actual_price'];

                    $i++;
                    $items[]=$this->get_sales_customer_row($report_type,$pack);
                }
            }
            $items[]=$this->get_total_sales_customer_row('crop',$report_type,$po_quantity_crop,$bonus_quantity_crop,$return_quantity_crop,$bonus_return_quantity_crop,$total_po_quantity_crop,$actual_quantity_crop,$po_price_crop,$actual_price_crop);
            $po_quantity_crop=0;
            $bonus_quantity_crop=0;
            $return_quantity_crop=0;
            $bonus_return_quantity_crop=0;
            $total_po_quantity_crop=0;
            $actual_quantity_crop=0;
            $po_price_crop=0;
            $actual_price_crop=0;


            $items[]=$this->get_total_sales_customer_row('customer',$report_type,$po_quantity_customer,$bonus_quantity_customer,$return_quantity_customer,$bonus_return_quantity_customer,$total_po_quantity_customer,$actual_quantity_customer,$po_price_customer,$actual_price_customer);
            $po_quantity_customer=0;
            $bonus_quantity_customer=0;
            $return_quantity_customer=0;
            $bonus_return_quantity_customer=0;
            $total_po_quantity_customer=0;
            $actual_quantity_customer=0;
            $po_price_customer=0;
            $actual_price_customer=0;
        }
        $items[]=$this->get_total_sales_customer_row('grand',$report_type,$po_quantity_grand,$bonus_quantity_grand,$return_quantity_grand,$bonus_return_quantity_grand,$total_po_quantity_grand,$actual_quantity_grand,$po_price_grand,$actual_price_grand);


        $this->jsonReturn($items);
    }
    private function get_total_sales_customer_row($total_type,$report_type,$po_quantity,$bonus_quantity,$return_quantity,$bonus_return_quantity,$total_po_quantity,$actual_quantity,$po_price,$actual_price)
    {
        $info=array();
        $info['name']='';
        $info['division_name']='';
        $info['zone_name']='';
        $info['territory_name']='';
        if($total_type=='grand')
        {
            $info['territory_name']='Grand Total';
        }
        $info['district_name']='';
        if($total_type=='customer')
        {
            $info['district_name']='Customer Total';
        }
        $info['crop_name']='';
        if($total_type=='crop')
        {
            $info['crop_name']='Crop Total';
        }
        $info['crop_type_name']='';

        $info['variety_name']='';
        $info['pack_size']='';
        if($report_type=='weight')
        {
            $info['po_quantity']=number_format($po_quantity/1000,3,'.','');
            $info['bonus_quantity']=number_format($bonus_quantity/1000,3,'.','');
            $info['return_quantity']=number_format($return_quantity/1000,3,'.','');
            $info['bonus_return_quantity']=number_format($bonus_return_quantity/1000,3,'.','');
            $info['total_po_quantity']=number_format($total_po_quantity/1000,3,'.','');
            $info['actual_quantity']=number_format($actual_quantity/1000,3,'.','');
        }
        else
        {
            $info['po_quantity']=$po_quantity;
            $info['bonus_quantity']=$bonus_quantity;
            $info['return_quantity']=$return_quantity;
            $info['bonus_return_quantity']=$bonus_return_quantity;
            $info['total_po_quantity']=$total_po_quantity;
            $info['actual_quantity']=$actual_quantity;
        }

        $info['po_price']=number_format($po_price,2);
        $info['actual_price']=number_format($actual_price,2);
        return $info;
    }
    private function get_return_validity($time_start,$time_end,$time)
    {
        if($time>0)
        {
            if(($time_start>0)&&($time_end>0))
            {
                if(($time>=$time_start)&&($time<=$time_end))
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            elseif(($time_end>0))
            {
                if(($time<=$time_end))
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            elseif(($time_start>0))
            {
                if(($time>=$time_start))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }

        }
        else
        {
            return false;
        }

    }
    private function get_sales_customer_row($report_type,$info)
    {
        /*{ name: 'id', type: 'int' },
        { name: 'name', type: 'string' },
        { name: 'division_name', type: 'numeric' },
        { name: 'zone_name', type: 'string' },
        { name: 'territory_name', type: 'string' },
        { name: 'district_name', type: 'string' },
        { name: 'crop_name', type: 'string' },
        { name: 'crop_type_name', type: 'string' },
        { name: 'variety_name', type: 'string' },
        { name: 'pack_size', type: 'string' },
        { name: 'po_quantity', type: 'string' },
        { name: 'bonus_quantity', type: 'string' },
        { name: 'return_quantity', type: 'string' },
        { name: 'bonus_return_quantity', type: 'string' },
        { name: 'total_po_quantity', type: 'string' },
        { name: 'actual_quantity', type: 'string' },
        { name: 'po_price', type: 'string' },
        { name: 'actual_price', type: 'string' }*/
        $row=array();

        $row['name']=$info['name'];
        $row['division_name']=$info['division_name'];
        $row['zone_name']=$info['zone_name'];
        $row['territory_name']=$info['territory_name'];
        $row['district_name']=$info['district_name'];
        $row['crop_name']=$info['crop_name'];
        $row['crop_type_name']=$info['crop_type_name'];
        $row['variety_name']=$info['variety_name'];
        $row['pack_size']=$info['pack_size'];
        $row['po_quantity']=$info['po_quantity'];
        $row['bonus_quantity']=$info['bonus_quantity'];
        $row['return_quantity']=$info['return_quantity'];
        $row['bonus_return_quantity']=$info['bonus_return_quantity'];
        $row['total_po_quantity']=$info['total_po_quantity'];
        $row['actual_quantity']=$info['actual_quantity'];
        $row['po_price']=number_format($info['po_price'],2);
        $row['actual_price']=number_format($info['actual_price'],2);
        if($report_type=='weight')
        {
            $row['po_quantity']=number_format($info['po_quantity']*$info['pack_size']/1000,3,'.','');
            $row['bonus_quantity']=number_format($info['bonus_quantity']*$info['pack_size']/1000,3,'.','');
            $row['return_quantity']=number_format($info['return_quantity']*$info['pack_size']/1000,3,'.','');
            $row['bonus_return_quantity']=number_format($info['bonus_return_quantity']*$info['pack_size']/1000,3,'.','');
            $row['total_po_quantity']=number_format($info['total_po_quantity']*$info['pack_size']/1000,3,'.','');
            $row['actual_quantity']=number_format($info['actual_quantity']*$info['pack_size']/1000,3,'.','');
        }
        return $row;
    }
    public function get_items_po()
    {
        $items=array();
        $division_id=$this->input->post('division_id');
        $zone_id=$this->input->post('zone_id');
        $territory_id=$this->input->post('territory_id');
        $district_id=$this->input->post('district_id');
        $customer_id=$this->input->post('customer_id');

        $report_type=$this->input->post('report_type');//means kg/pkt

        $warehouse_id=$this->input->post('warehouse_id');
        $crop_id=$this->input->post('crop_id');
        $crop_type_id=$this->input->post('crop_type_id');
        $variety_id=$this->input->post('variety_id');
        $pack_size_id=$this->input->post('pack_size_id');
        $date_end=$this->input->post('date_end');
        $date_start=$this->input->post('date_start');

        $po_no=$this->input->post('po_no');
        if($po_no)
        {
            $po_no=intval($po_no);
            if(!($po_no>0))
            {
                $this->jsonReturn($items);
            }
        }
        $this->db->from($this->config->item('table_sales_po_details').' pod');

        $this->db->select('pod.*');



        $this->db->select('po.id po_no,po.date_po');
        $this->db->select('CONCAT(cus.customer_code," - ",cus.name) name');
        $this->db->select('d.name district_name');
        $this->db->select('t.name territory_name');
        $this->db->select('zone.name zone_name');
        $this->db->select('division.name division_name');
        $this->db->select('v.name variety_name');
        $this->db->select('crop_type.name crop_type_name');
        $this->db->select('crop.name crop_name');

        $this->db->join($this->config->item('table_sales_po').' po','po.id = pod.sales_po_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = po.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id =pod.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id =v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id =crop_type.crop_id','INNER');

        $this->db->where('pod.revision',1);
        $this->db->where('po.status_approved',$this->config->item('system_status_po_approval_approved'));
        if($po_no>0)
        {
            $this->db->where('po.id',$po_no);
        }
        else
        {
            if($date_end>0)
            {
                $this->db->where('po.date_approved <=',$date_end);
            }
            if($date_start>0)
            {
                $this->db->where('po.date_approved >=',$date_start);
            }
            if($warehouse_id>0)
            {
                $this->db->where('po.warehouse_id',$warehouse_id);
            }
            if($crop_id>0)
            {
                $this->db->where('crop.id',$crop_id);
            }
            if($crop_type_id>0)
            {
                $this->db->where('crop_type.id',$crop_type_id);
            }
            if($variety_id>0)
            {
                $this->db->where('pod.variety_id',$variety_id);
            }
            if($pack_size_id>0)
            {
                $this->db->where('pod.pack_size_id',$pack_size_id);
            }
            if($division_id>0)
            {
                $this->db->where('division.id',$division_id);
                if($zone_id>0)
                {
                    $this->db->where('zone.id',$zone_id);
                    if($territory_id>0)
                    {
                        $this->db->where('t.id',$territory_id);
                        if($district_id>0)
                        {
                            $this->db->where('d.id',$district_id);
                            if($customer_id>0)
                            {
                                $this->db->where('cus.id',$customer_id);
                            }
                        }
                    }
                }
            }
        }
        $this->db->order_by('po.id','ASC');
        $results=$this->db->get()->result_array();
        $current_po_no='';
        $total_price=0;
        $total_quantity=0;
        $total_bonus_quantity=0;
        $grand_total_price=0;
        $grand_total_quantity=0;
        $grand_total_bonus_quantity=0;
        if(!$results)
        {
            $this->jsonReturn($items);
        }
        $sl_no=1;
        foreach($results as $count=>$result)
        {
            $info=array();
            if($count>0)
            {
                if($current_po_no!=$result['po_no'])
                {
                    $current_po_no=$result['po_no'];
                    $total_info=array();
                    $total_info['sl_no']='';
                    $total_info['po_no']='';
                    $total_info['name']='';
                    $total_info['date_po']='';
                    $total_info['division_name']='';
                    $total_info['zone_name']='';
                    $total_info['territory_name']='';
                    $total_info['district_name']='';
                    $total_info['crop_name']='';
                    $total_info['crop_type_name']='';
                    $total_info['variety_name']='Total';
                    $total_info['pack_size']='';
                    $total_info['quantity']=$total_quantity;
                    $total_info['bonus_pack_size']='';
                    $total_info['quantity_bonus']=$total_bonus_quantity;
                    $total_info['variety_price']='';
                    $total_info['price_total']=$total_price;
                    $items[]=$this->get_po_row($report_type,$total_info);


                    $total_price=0;
                    $total_quantity=0;
                    $total_bonus_quantity=0;
                    $info['po_no']=$result['po_no'];
                    $info['name']=$result['name'];
                    $info['date_po']=$result['date_po'];
                    $info['division_name']=$result['division_name'];
                    $info['zone_name']=$result['zone_name'];
                    $info['territory_name']=$result['territory_name'];
                    $info['district_name']=$result['district_name'];
                }
                else
                {
                    $info['po_no']='';
                    $info['name']='';
                    $info['date_po']='';
                    $info['division_name']='';
                    $info['zone_name']='';
                    $info['territory_name']='';
                    $info['district_name']='';
                }


            }
            else
            {
                $current_po_no=$result['po_no'];
                $info['po_no']=$result['po_no'];
                $info['name']=$result['name'];
                $info['date_po']=$result['date_po'];
                $info['division_name']=$result['division_name'];
                $info['zone_name']=$result['zone_name'];
                $info['territory_name']=$result['territory_name'];
                $info['district_name']=$result['district_name'];

            }
            if($info['po_no']>0)
            {
                $info['sl_no']=$sl_no;
                $sl_no++;
            }
            else
            {
                $info['sl_no']='';
            }

            $info['crop_name']=$result['crop_name'];
            $info['crop_type_name']=$result['crop_type_name'];
            $info['variety_name']=$result['variety_name'];
            $info['pack_size']=$result['pack_size'];
            $info['quantity']=$result['quantity'];

            $info['bonus_pack_size']=$result['bonus_pack_size'];
            $info['quantity_bonus']=$result['quantity_bonus'];


            $quantity=$result['quantity'];
            $quantity_bonus=$result['quantity_bonus'];
            if($report_type=='weight')
            {
                $quantity=$result['quantity']*$info['pack_size'];
                $quantity_bonus=$result['quantity_bonus']*$info['bonus_pack_size'];
                $info['quantity']=$quantity;
                $info['quantity_bonus']=$quantity_bonus;
            }
            $total_quantity+=$quantity;
            $grand_total_quantity+=$quantity;
            $total_bonus_quantity+=$quantity_bonus;
            $grand_total_bonus_quantity+=$quantity_bonus;




            $info['variety_price']=$result['variety_price'];
            $price=$result['quantity']*$result['variety_price'];
            $info['price_total']=$price;
            $total_price+=$price;
            $grand_total_price+=$price;
            $items[]=$this->get_po_row($report_type,$info);
            //$items[]=$this->get_po_row($report_type,$result['po_no'],$result['name'],$result['date_po'],$result['division_name'],$result['zone_name'],$result['territory_name'],$result['district_name'],$result['crop_name'],$result['crop_type_name'],$result['variety_name'],$result['pack_size'],$result['quantity'],$result['bonus_pack_size'],$result['quantity_bonus'],$result['variety_price'],'123');

        }

        $total_info=array();
        $total_info['sl_no']='';
        $total_info['po_no']='';
        $total_info['name']='';
        $total_info['date_po']='';
        $total_info['division_name']='';
        $total_info['zone_name']='';
        $total_info['territory_name']='';
        $total_info['district_name']='';
        $total_info['crop_name']='';
        $total_info['crop_type_name']='';
        $total_info['variety_name']='Total';
        $total_info['pack_size']='';
        $total_info['quantity']=$total_quantity;
        $total_info['bonus_pack_size']='';
        $total_info['quantity_bonus']=$total_bonus_quantity;
        $total_info['variety_price']='';
        $total_info['price_total']=$total_price;
        $items[]=$this->get_po_row($report_type,$total_info);

        $total_info=array();
        $total_info['sl_no']=($sl_no-1);
        $total_info['po_no']='';
        $total_info['name']='';
        $total_info['date_po']='';
        $total_info['division_name']='';
        $total_info['zone_name']='';
        $total_info['territory_name']='';
        $total_info['district_name']='';
        $total_info['crop_name']='';
        $total_info['crop_type_name']='Grand Total';
        $total_info['variety_name']='';
        $total_info['pack_size']='';
        $total_info['quantity']=$grand_total_quantity;
        $total_info['bonus_pack_size']='';
        $total_info['quantity_bonus']=$grand_total_bonus_quantity;
        $total_info['variety_price']='';
        $total_info['price_total']=$grand_total_price;
        $items[]=$this->get_po_row($report_type,$total_info);
        $this->jsonReturn($items);
    }
    private function get_po_row($report_type,$info)
    {
        $row=array();
        $row['sl_no']=$info['sl_no'];
        $row['po_no']=$info['po_no'];
        if($info['po_no'])
        {
            $row['po_no']=str_pad($info['po_no'],$this->config->item('system_po_no_length'),'0',STR_PAD_LEFT);
        }

        $row['name']=$info['name'];
        $row['date_po']='';
        if($info['date_po'])
        {
            $row['date_po']=System_helper::display_date($info['date_po']);
        }

        $row['division_name']=$info['division_name'];
        $row['zone_name']=$info['zone_name'];
        $row['territory_name']=$info['territory_name'];
        $row['district_name']=$info['district_name'];
        $row['crop_name']=$info['crop_name'];
        $row['crop_type_name']=$info['crop_type_name'];
        $row['variety_name']=$info['variety_name'];
        $row['pack_size']=$info['pack_size'];
        $row['quantity']=$info['quantity'];
        $row['bonus_pack_size']=$info['bonus_pack_size'];
        $row['quantity_bonus']=$info['quantity_bonus'];
        $row['variety_price']='';
        if($info['variety_price'])
        {
            $row['variety_price']=number_format($info['variety_price'],2);
        }

        $row['price_total']=number_format($info['price_total'],2);

        if($report_type=='weight')
        {
            $row['quantity']=number_format($info['quantity']/1000,3,'.','');
            $row['quantity_bonus']=number_format($info['quantity_bonus']/1000,3,'.','');
            if($info['variety_price'])
            {
                $row['variety_price']=number_format($info['variety_price']*1000/$info['pack_size'],2);
            }

        }
        return $row;
    }
    public function get_items_sales_return()
    {
        $items=array();
        $division_id=$this->input->post('division_id');
        $zone_id=$this->input->post('zone_id');
        $territory_id=$this->input->post('territory_id');
        $district_id=$this->input->post('district_id');
        $customer_id=$this->input->post('customer_id');

        $report_type=$this->input->post('report_type');//means kg/pkt

        $warehouse_id=$this->input->post('warehouse_id');
        $crop_id=$this->input->post('crop_id');
        $crop_type_id=$this->input->post('crop_type_id');
        $variety_id=$this->input->post('variety_id');
        $pack_size_id=$this->input->post('pack_size_id');
        $date_end=$this->input->post('date_end');
        $date_start=$this->input->post('date_start');

        $po_no=$this->input->post('po_no');
        if($po_no)
        {
            $po_no=intval($po_no);
            if(!($po_no>0))
            {
                $this->jsonReturn($items);
            }
        }
        $this->db->from($this->config->item('table_sales_po_details').' pod');

        $this->db->select('pod.*');



        $this->db->select('po.id po_no,po.date_po');
        $this->db->select('CONCAT(cus.customer_code," - ",cus.name) name');
        $this->db->select('d.name district_name');
        $this->db->select('t.name territory_name');
        $this->db->select('zone.name zone_name');
        $this->db->select('division.name division_name');
        $this->db->select('v.name variety_name');
        $this->db->select('crop_type.name crop_type_name');
        $this->db->select('crop.name crop_name');

        $this->db->join($this->config->item('table_sales_po').' po','po.id = pod.sales_po_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = po.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id =pod.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id =v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id =crop_type.crop_id','INNER');

        $this->db->where('pod.revision',1);
        $this->db->where('po.status_approved',$this->config->item('system_status_po_approval_approved'));
        $this->db->where('pod.date_return >',0);
        if($po_no>0)
        {
            $this->db->where('po.id',$po_no);
        }
        else
        {
            if($date_end>0)
            {
                $this->db->where('pod.date_return <=',$date_end);
            }
            if($date_start>0)
            {
                $this->db->where('pod.date_return >=',$date_start);
            }
            if($warehouse_id>0)
            {
                $this->db->where('po.warehouse_id',$warehouse_id);
            }
            if($crop_id>0)
            {
                $this->db->where('crop.id',$crop_id);
            }
            if($crop_type_id>0)
            {
                $this->db->where('crop_type.id',$crop_type_id);
            }
            if($variety_id>0)
            {
                $this->db->where('pod.variety_id',$variety_id);
            }
            if($pack_size_id>0)
            {
                $this->db->where('pod.pack_size_id',$pack_size_id);
            }
            if($division_id>0)
            {
                $this->db->where('division.id',$division_id);
                if($zone_id>0)
                {
                    $this->db->where('zone.id',$zone_id);
                    if($territory_id>0)
                    {
                        $this->db->where('t.id',$territory_id);
                        if($district_id>0)
                        {
                            $this->db->where('d.id',$district_id);
                            if($customer_id>0)
                            {
                                $this->db->where('cus.id',$customer_id);
                            }
                        }
                    }
                }
            }
        }
        $this->db->order_by('po.id','ASC');
        $results=$this->db->get()->result_array();

        if(!$results)
        {
            $this->jsonReturn($items);
        }
        $prev_po='';
        $po_quantity_total=0;
        $po_quantity_grand=0;
        $bonus_quantity_total=0;
        $bonus_quantity_grand=0;
        $return_quantity_total=0;
        $return_quantity_grand=0;
        $bonus_return_quantity_total=0;
        $bonus_return_quantity_grand=0;
        $total_po_quantity_total=0;
        $total_po_quantity_grand=0;
        $actual_quantity_total=0;
        $actual_quantity_grand=0;
        $po_price_total=0;
        $po_price_grand=0;
        $actual_price_total=0;
        $actual_price_grand=0;
        foreach($results as $count=>$result)
        {
            if($count>0)
            {
                if($result['po_no']!=$prev_po)
                {
                    $prev_po=$result['po_no'];
                    $items[]=$this->get_total_sales_return_row('total',$report_type,$po_quantity_total,$bonus_quantity_total,$return_quantity_total,$bonus_return_quantity_total,$total_po_quantity_total,$actual_quantity_total,$po_price_total,$actual_price_total);
                    $po_quantity_total=0;
                    $bonus_quantity_total=0;
                    $return_quantity_total=0;
                    $bonus_return_quantity_total=0;
                    $total_po_quantity_total=0;
                    $actual_quantity_total=0;
                    $po_price_total=0;
                    $actual_price_total=0;
                    //go total row
                }
                else
                {
                    $result['po_no']='';
                    $result['name']='';
                    $result['date_po']='';
                    $result['date_return']='';
                    $result['division_name']='';
                    $result['zone_name']='';
                    $result['territory_name']='';
                    $result['district_name']='';
                }
            }
            else
            {
                $prev_po=$result['po_no'];

            }
            $result['po_quantity']=$result['quantity'];
            $result['bonus_quantity']=$result['quantity_bonus'];
            $result['return_quantity']=$result['quantity_return'];
            $result['bonus_return_quantity']=$result['quantity_bonus_return'];
            $result['total_po_quantity']=$result['po_quantity']+$result['bonus_quantity']-$result['return_quantity']-$result['bonus_return_quantity'];
            if($report_type=='weight')
            {
                $result['total_po_quantity']=($result['po_quantity']-$result['return_quantity'])*$result['pack_size']+($result['bonus_quantity']-$result['bonus_return_quantity'])*$result['bonus_pack_size'];
                $total_po_quantity_total+=$result['total_po_quantity'];
                $total_po_quantity_grand+=$result['total_po_quantity'];
            }
            $result['actual_quantity']=$result['po_quantity']-$result['return_quantity'];
            $result['po_price']=$result['po_quantity']*$result['variety_price'];
            $result['actual_price']=$result['actual_quantity']*$result['variety_price'];
            if($report_type=='weight')
            {
                $po_quantity_total+=$result['po_quantity']*$result['pack_size'];
                $po_quantity_grand+=$result['po_quantity']*$result['pack_size'];
                $bonus_quantity_total+=$result['bonus_quantity']*$result['bonus_pack_size'];
                $bonus_quantity_grand+=$result['bonus_quantity']*$result['bonus_pack_size'];
                $return_quantity_total+=$result['return_quantity']*$result['pack_size'];
                $return_quantity_grand+=$result['return_quantity']*$result['pack_size'];
                $bonus_return_quantity_total+=$result['bonus_return_quantity']*$result['bonus_pack_size'];
                $bonus_return_quantity_grand+=$result['bonus_return_quantity']*$result['bonus_pack_size'];
                $actual_quantity_total+=$result['actual_quantity']*$result['pack_size'];
                $actual_quantity_grand+=$result['actual_quantity']*$result['pack_size'];
            }
            else
            {
                $po_quantity_total+=$result['po_quantity'];
                $po_quantity_grand+=$result['po_quantity'];
                $bonus_quantity_total+=$result['bonus_quantity'];
                $bonus_quantity_grand+=$result['bonus_quantity'];
                $return_quantity_total+=$result['return_quantity'];
                $return_quantity_grand+=$result['return_quantity'];
                $bonus_return_quantity_total+=$result['bonus_return_quantity'];
                $bonus_return_quantity_grand+=$result['bonus_return_quantity'];
                $total_po_quantity_total+=$result['total_po_quantity'];
                $total_po_quantity_grand+=$result['total_po_quantity'];
                $actual_quantity_total+=$result['actual_quantity'];
                $actual_quantity_grand+=$result['actual_quantity'];
            }
            $po_price_total+=$result['po_price'];
            $po_price_grand+=$result['po_price'];
            $actual_price_total+=$result['actual_price'];
            $actual_price_grand+=$result['actual_price'];

            $items[]=$this->get_sales_return_row($report_type,$result);
        }
        $items[]=$this->get_total_sales_return_row('total',$report_type,$po_quantity_total,$bonus_quantity_total,$return_quantity_total,$bonus_return_quantity_total,$total_po_quantity_total,$actual_quantity_total,$po_price_total,$actual_price_total);
        $items[]=$this->get_total_sales_return_row('grand',$report_type,$po_quantity_grand,$bonus_quantity_grand,$return_quantity_grand,$bonus_return_quantity_grand,$total_po_quantity_grand,$actual_quantity_grand,$po_price_grand,$actual_price_grand);
        $this->jsonReturn($items);
    }
    private function get_total_sales_return_row($total_type,$report_type,$po_quantity,$bonus_quantity,$return_quantity,$bonus_return_quantity,$total_po_quantity,$actual_quantity,$po_price,$actual_price)
    {
        $info=array();
        $info['po_no']='';
        $info['name']='';
        $info['date_po']='';
        $info['date_return']='';
        $info['division_name']='';
        $info['zone_name']='';
        $info['territory_name']='';
        if($total_type=='grand')
        {
            $info['territory_name']='Grand Total';
        }
        $info['district_name']='';
        if($total_type=='total')
        {
            $info['district_name']='Total';
        }
        $info['crop_name']='';
        $info['crop_type_name']='';
        $info['variety_name']='';
        $info['pack_size']='';
        $info['bonus_pack_size']='';
        if($report_type=='weight')
        {
            $info['po_quantity']=number_format($po_quantity/1000,3,'.','');
            $info['bonus_quantity']=number_format($bonus_quantity/1000,3,'.','');
            $info['return_quantity']=number_format($return_quantity/1000,3,'.','');
            $info['bonus_return_quantity']=number_format($bonus_return_quantity/1000,3,'.','');
            $info['total_po_quantity']=number_format($total_po_quantity/1000,3,'.','');
            $info['actual_quantity']=number_format($actual_quantity/1000,3,'.','');
        }
        else
        {
            $info['po_quantity']=$po_quantity;
            $info['bonus_quantity']=$bonus_quantity;
            $info['return_quantity']=$return_quantity;
            $info['bonus_return_quantity']=$bonus_return_quantity;
            $info['total_po_quantity']=$total_po_quantity;
            $info['actual_quantity']=$actual_quantity;
        }

        $info['po_price']=number_format($po_price,2);
        $info['actual_price']=number_format($actual_price,2);
        return $info;
    }
    private function get_sales_return_row($report_type,$info)
    {
        $row=array();
        $row['po_no']=$info['po_no'];
        if($info['po_no'])
        {
            $row['po_no']=str_pad($info['po_no'],$this->config->item('system_po_no_length'),'0',STR_PAD_LEFT);
        }
        $row['name']=$info['name'];
        $row['date_po']='';
        if($info['date_po'])
        {
            $row['date_po']=System_helper::display_date($info['date_po']);
        }
        $row['date_return']='';
        if($info['date_return'])
        {
            $row['date_return']=System_helper::display_date($info['date_return']);
        }
        $row['division_name']=$info['division_name'];
        $row['zone_name']=$info['zone_name'];
        $row['territory_name']=$info['territory_name'];
        $row['district_name']=$info['district_name'];
        $row['crop_name']=$info['crop_name'];
        $row['crop_type_name']=$info['crop_type_name'];
        $row['variety_name']=$info['variety_name'];
        $row['pack_size']=$info['pack_size'];
        $row['po_quantity']=$info['po_quantity'];
        $row['bonus_pack_size']=$info['bonus_pack_size'];
        $row['bonus_quantity']=$info['bonus_quantity'];
        $row['return_quantity']=$info['return_quantity'];
        $row['bonus_return_quantity']=$info['bonus_return_quantity'];
        $row['total_po_quantity']=$info['total_po_quantity'];
        $row['actual_quantity']=$info['actual_quantity'];
        $row['po_price']=number_format($info['po_price'],2);
        $row['actual_price']=number_format($info['actual_price'],2);
        if($report_type=='weight')
        {
            $row['po_quantity']=number_format($info['po_quantity']*$info['pack_size']/1000,3,'.','');
            $row['bonus_quantity']=number_format($info['bonus_quantity']*$info['bonus_pack_size']/1000,3,'.','');
            $row['return_quantity']=number_format($info['return_quantity']*$info['pack_size']/1000,3,'.','');
            $row['bonus_return_quantity']=number_format($info['bonus_return_quantity']*$info['bonus_pack_size']/1000,3,'.','');
            $row['total_po_quantity']=number_format($info['total_po_quantity']/1000,3,'.','');
            $row['actual_quantity']=number_format($info['actual_quantity']*$info['pack_size']/1000,3,'.','');
        }
        return $row;
    }
    public function get_items_sales_area()
    {
        $items=array();
        $division_id=$this->input->post('division_id');
        $zone_id=$this->input->post('zone_id');
        $territory_id=$this->input->post('territory_id');
        $district_id=$this->input->post('district_id');
        $customer_id=$this->input->post('customer_id');

        $report_type=$this->input->post('report_type');//means kg/pkt

        $warehouse_id=$this->input->post('warehouse_id');
        $crop_id=$this->input->post('crop_id');
        $crop_type_id=$this->input->post('crop_type_id');
        $variety_id=$this->input->post('variety_id');
        $pack_size_id=$this->input->post('pack_size_id');
        $date_end=$this->input->post('date_end');
        $date_start=$this->input->post('date_start');
        if($customer_id>0)
        {
            $areas=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','name text'),array('id ='.$customer_id));
            $location_type='customer_id';
        }
        elseif($district_id>0)
        {
            $areas=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','name text'),array('district_id ='.$district_id));
            $location_type='customer_id';
        }
        elseif($territory_id>0)
        {
            $areas=Query_helper::get_info($this->config->item('table_setup_location_districts'),array('id value','name text'),array('territory_id ='.$territory_id));
            $location_type='district_id';
        }
        elseif($zone_id>0)
        {
            $areas=Query_helper::get_info($this->config->item('table_setup_location_territories'),array('id value','name text'),array('zone_id ='.$zone_id));
            $location_type='territory_id';
        }
        elseif($division_id>0)
        {
            $areas=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('division_id ='.$division_id));
            $location_type='zone_id';
        }
        else
        {
            $areas=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $location_type='division_id';
        }

        $po_no=$this->input->post('po_no');
        if($po_no)
        {
            $po_no=intval($po_no);
            if(!($po_no>0))
            {
                $this->jsonReturn($items);
            }
        }
        $this->db->from($this->config->item('table_sales_po_details').' pod');

        $this->db->select('pod.pack_size_id,pod.variety_id,pod.pack_size');
        $this->db->select('SUM(quantity) quantity');

        $this->db->select('SUM(quantity*variety_price) price');

        $this->db->select('cus.id customer_id,cus.name customer_name');
        $this->db->select('d.name district_name,d.id district_id');
        $this->db->select('t.name territory_name,t.id territory_id');
        $this->db->select('zone.name zone_name,zone.id zone_id');
        $this->db->select('division.name division_name,division.id division_id');
        $this->db->select('v.name variety_name');
        $this->db->select('crop_type.name crop_type_name');
        $this->db->select('crop.name crop_name');

        $this->db->join($this->config->item('table_sales_po').' po','po.id = pod.sales_po_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = po.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id =pod.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id =v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id =crop_type.crop_id','INNER');

        $this->db->where('pod.revision',1);
        $this->db->where('po.status_approved',$this->config->item('system_status_po_approval_approved'));


        if($po_no>0)
        {
            $this->db->where('po.id',$po_no);
        }
        else
        {
            if($date_end>0)
            {
                $this->db->where('po.date_approved <=',$date_end);
            }
            if($date_start>0)
            {
                $this->db->where('po.date_approved >=',$date_start);
            }
            if($warehouse_id>0)
            {
                $this->db->where('po.warehouse_id',$warehouse_id);
            }
            if($crop_id>0)
            {
                $this->db->where('crop.id',$crop_id);
            }
            if($crop_type_id>0)
            {
                $this->db->where('crop_type.id',$crop_type_id);
            }
            if($variety_id>0)
            {
                $this->db->where('pod.variety_id',$variety_id);
            }
            if($pack_size_id>0)
            {
                $this->db->where('pod.pack_size_id',$pack_size_id);
            }
            if($division_id>0)
            {
                $this->db->where('division.id',$division_id);
                if($zone_id>0)
                {
                    $this->db->where('zone.id',$zone_id);
                    if($territory_id>0)
                    {
                        $this->db->where('t.id',$territory_id);
                        if($district_id>0)
                        {
                            $this->db->where('d.id',$district_id);
                            if($customer_id>0)
                            {
                                $this->db->where('cus.id',$customer_id);
                            }
                        }
                    }
                }
            }
        }
        $group_array=array('variety_id','pack_size_id');
        $group_array[]=$location_type;
        $this->db->group_by($group_array);

        $this->db->order_by('crop.ordering,crop.id,crop_type.ordering,crop_type.id,v.ordering,v.id');
        $results=$this->db->get()->result_array();


        $varieties=array();
        foreach($results as $result)
        {
            if(isset($varieties[$result['variety_id']][$result['pack_size_id']]))
            {
                if($report_type=='weight')
                {
                    $varieties[$result['variety_id']][$result['pack_size_id']]['quantity_'.$result[$location_type]]+=$result['quantity']*$result['pack_size'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['total_quantity']+=$result['quantity']*$result['pack_size'];
                }
                else
                {
                    $varieties[$result['variety_id']][$result['pack_size_id']]['quantity_'.$result[$location_type]]+=$result['quantity'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['total_quantity']+=$result['quantity'];
                }
                $varieties[$result['variety_id']][$result['pack_size_id']]['price_'.$result[$location_type]]+=$result['price'];
                $varieties[$result['variety_id']][$result['pack_size_id']]['total_price']+=$result['price'];
            }
            else
            {
                $info=array();
                $info['crop_name']=$result['crop_name'];
                $info['crop_type_name']=$result['crop_type_name'];
                $info['variety_name']=$result['variety_name'];
                $info['variety_name']=$result['variety_name'];
                $info['pack_size']=$result['pack_size'];
                foreach($areas as $area)
                {
                    $info['quantity_'.$area['value']]=0;
                    $info['price_'.$area['value']]=0;
                }
                $info['total_quantity']=0;
                $info['total_price']=0;
                if($report_type=='weight')
                {
                    $info['quantity_'.$result[$location_type]]+=$result['quantity']*$result['pack_size'];
                    $info['total_quantity']+=$result['quantity']*$result['pack_size'];
                }
                else
                {
                    $info['quantity_'.$result[$location_type]]+=$result['quantity'];
                    $info['total_quantity']+=$result['quantity'];
                }
                $info['price_'.$result[$location_type]]+=$result['price'];
                $info['total_price']+=$result['price'];
                $varieties[$result['variety_id']][$result['pack_size_id']]=$info;
            }
        }
        //sales return starts
        $this->db->from($this->config->item('table_sales_po_details').' pod');

        $this->db->select('pod.pack_size_id,pod.variety_id,pod.pack_size');
        $this->db->select('SUM(quantity_return) quantity');
        $this->db->select('SUM(quantity_return*variety_price) price');

        $this->db->select('cus.id customer_id,cus.name customer_name');
        $this->db->select('d.name district_name,d.id district_id');
        $this->db->select('t.name territory_name,t.id territory_id');
        $this->db->select('zone.name zone_name,zone.id zone_id');
        $this->db->select('division.name division_name,division.id division_id');
        $this->db->select('v.name variety_name');
        $this->db->select('crop_type.name crop_type_name');
        $this->db->select('crop.name crop_name');

        $this->db->join($this->config->item('table_sales_po').' po','po.id = pod.sales_po_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = po.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id =pod.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id =v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id =crop_type.crop_id','INNER');

        $this->db->where('pod.revision',1);
        $this->db->where('po.status_approved',$this->config->item('system_status_po_approval_approved'));

        $this->db->where('pod.date_return >',0);


        if($po_no>0)
        {
            $this->db->where('po.id',$po_no);
        }
        else
        {
            if($date_end>0)
            {
                $this->db->where('pod.date_return <=',$date_end);
            }
            if($date_start>0)
            {
                $this->db->where('pod.date_return >=',$date_start);
            }
            if($warehouse_id>0)
            {
                $this->db->where('po.warehouse_id',$warehouse_id);
            }
            if($crop_id>0)
            {
                $this->db->where('crop.id',$crop_id);
            }
            if($crop_type_id>0)
            {
                $this->db->where('crop_type.id',$crop_type_id);
            }
            if($variety_id>0)
            {
                $this->db->where('pod.variety_id',$variety_id);
            }
            if($pack_size_id>0)
            {
                $this->db->where('pod.pack_size_id',$pack_size_id);
            }
            if($division_id>0)
            {
                $this->db->where('division.id',$division_id);
                if($zone_id>0)
                {
                    $this->db->where('zone.id',$zone_id);
                    if($territory_id>0)
                    {
                        $this->db->where('t.id',$territory_id);
                        if($district_id>0)
                        {
                            $this->db->where('d.id',$district_id);
                            if($customer_id>0)
                            {
                                $this->db->where('cus.id',$customer_id);
                            }
                        }
                    }
                }
            }
        }
        $this->db->group_by($group_array);
        $results=$this->db->get()->result_array();
        foreach($results as $result)
        {
            if(isset($varieties[$result['variety_id']][$result['pack_size_id']]))
            {
                if($report_type=='weight')
                {
                    $varieties[$result['variety_id']][$result['pack_size_id']]['quantity_'.$result[$location_type]]-=$result['quantity']*$result['pack_size'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['total_quantity']-=$result['quantity']*$result['pack_size'];
                }
                else
                {
                    $varieties[$result['variety_id']][$result['pack_size_id']]['quantity_'.$result[$location_type]]-=$result['quantity'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['total_quantity']-=$result['quantity'];
                }
                $varieties[$result['variety_id']][$result['pack_size_id']]['price_'.$result[$location_type]]-=$result['price'];
                $varieties[$result['variety_id']][$result['pack_size_id']]['total_price']-=$result['price'];
            }
            else
            {
                $info=array();
                $info['crop_name']=$result['crop_name'];
                $info['crop_type_name']=$result['crop_type_name'];
                $info['variety_name']=$result['variety_name'];
                $info['variety_name']=$result['variety_name'];
                $info['pack_size']=$result['pack_size'];
                foreach($areas as $area)
                {
                    $info['quantity_'.$area['value']]=0;
                    $info['price_'.$area['value']]=0;
                }
                $info['total_quantity']=0;
                $info['total_price']=0;
                if($report_type=='weight')
                {
                    $info['quantity_'.$result[$location_type]]-=$result['quantity']*$result['pack_size'];
                    $info['total_quantity']-=$result['quantity']*$result['pack_size'];
                }
                else
                {
                    $info['quantity_'.$result[$location_type]]-=$result['quantity'];
                    $info['total_quantity']-=$result['quantity'];
                }
                $info['price_'.$result[$location_type]]-=$result['price'];
                $info['total_price']-=$result['price'];
                $varieties[$result['variety_id']][$result['pack_size_id']]=$info;
            }
        }
        //sales return finished

        $prev_crop='';
        $prev_crop_type='';
        $prev_variety='';
        $total_quantity_crop=0;
        $total_quantity_grand=0;
        $total_price_crop=0;
        $total_price_grand=0;
        $area_totals_crop=array();
        $area_totals_grand=array();
        foreach($areas as $area)
        {
            $area_totals_crop[$area['value']]['quantity']=0;
            $area_totals_crop[$area['value']]['price']=0;
            $area_totals_grand[$area['value']]['quantity']=0;
            $area_totals_grand[$area['value']]['price']=0;

        }
        $count=0;
        foreach($varieties as $variety)
        {
            foreach($variety as $pack)
            {
                if($count>0)
                {
                    if($prev_crop!=$pack['crop_name'])
                    {
                        $prev_crop=$pack['crop_name'];
                        $prev_crop_type=$pack['crop_type_name'];
                        $prev_variety=$pack['variety_name'];
                        $items[]=$this->get_total_sales_area_row('total',$report_type,$areas,$total_quantity_crop,$total_price_crop,$area_totals_crop);
                        $total_quantity_crop=0;
                        $total_price_crop=0;
                        foreach($areas as $area)
                        {
                            $area_totals_crop[$area['value']]['quantity']=0;
                            $area_totals_crop[$area['value']]['price']=0;
                        }
                        //show total row
                    }
                    elseif($prev_crop_type!=$pack['crop_type_name'])
                    {
                        $pack['crop_name']='';
                        $prev_crop_type=$pack['crop_type_name'];
                        $prev_variety=$pack['variety_name'];
                    }
                    elseif($prev_variety!=$pack['variety_name'])
                    {
                        $pack['crop_name']='';
                        $pack['crop_type_name']='';
                        $prev_variety=$pack['variety_name'];
                    }
                    else
                    {
                        $pack['crop_name']='';
                        $pack['crop_type_name']='';
                        $pack['variety_name']='';
                    }

                }
                else
                {
                    $prev_crop=$pack['crop_name'];
                    $prev_crop_type=$pack['crop_type_name'];
                    $prev_variety=$pack['variety_name'];

                }
                $count++;

                foreach($areas as $area)
                {
                    $area_totals_crop[$area['value']]['quantity']+=$pack['quantity_'.$area['value']];
                    $area_totals_crop[$area['value']]['price']+=$pack['price_'.$area['value']];
                    $area_totals_grand[$area['value']]['quantity']+=$pack['quantity_'.$area['value']];
                    $area_totals_grand[$area['value']]['price']+=$pack['price_'.$area['value']];
                }

                $total_quantity_crop+=$pack['total_quantity'];
                $total_quantity_grand+=$pack['total_quantity'];
                $total_price_crop+=$pack['total_price'];
                $total_price_grand+=$pack['total_price'];

                $items[]=$this->get_sales_area_row($report_type,$areas,$pack);
            }
        }
        $items[]=$this->get_total_sales_area_row('total',$report_type,$areas,$total_quantity_crop,$total_price_crop,$area_totals_crop);
        $items[]=$this->get_total_sales_area_row('grand',$report_type,$areas,$total_quantity_grand,$total_price_grand,$area_totals_grand);
        $this->jsonReturn($items);
    }
    private function get_total_sales_area_row($total_type,$report_type,$areas,$total_quantity,$total_price,$area_totals)
    {
        $info=array();
        $info['crop_name']='';
        if($total_type=='grand')
        {
            $info['crop_name']='Grand Total';
        }
        $info['crop_type_name']='';
        if($total_type=='total')
        {
            $info['crop_type_name']='Total Crop';
        }
        $info['variety_name']='';
        $info['pack_size']='';

        if($report_type=='weight')
        {
            $info['total_quantity']=number_format($total_quantity/1000,3,'.','');
        }
        else
        {
            $info['total_quantity']=$total_quantity;
        }
        $info['total_price']=number_format($total_price,2);
        foreach($areas as $area)
        {
            if($report_type=='weight')
            {
                $info['quantity_'.$area['value']]=number_format($area_totals[$area['value']]['quantity']/1000,3,'.','');
            }
            else
            {
                $info['quantity_'.$area['value']]=$area_totals[$area['value']]['quantity'];
            }
            $info['price_'.$area['value']]=number_format($area_totals[$area['value']]['price'],2);
        }
        return $info;
    }
    private function get_sales_area_row($report_type,$areas,$info)
    {
        foreach($areas as $area)
        {
            $info['price_'.$area['value']]=number_format($info['price_'.$area['value']],2);
            if($report_type=='weight')
            {
                $info['quantity_'.$area['value']]=number_format($info['quantity_'.$area['value']]/1000,3,'.','');
            }
        }
        if($report_type=='weight')
        {
            $info['total_quantity']=number_format($info['total_quantity']/1000,3,'.','');
        }
        $info['total_price']=number_format($info['total_price'],2);
        return $info;
    }
    public function get_items_sales_product()
    {
        $items=array();
        $division_id=$this->input->post('division_id');
        $zone_id=$this->input->post('zone_id');
        $territory_id=$this->input->post('territory_id');
        $district_id=$this->input->post('district_id');
        $customer_id=$this->input->post('customer_id');

        $report_type=$this->input->post('report_type');//means kg/pkt

        $warehouse_id=$this->input->post('warehouse_id');
        $crop_id=$this->input->post('crop_id');
        $crop_type_id=$this->input->post('crop_type_id');
        $variety_id=$this->input->post('variety_id');
        $pack_size_id=$this->input->post('pack_size_id');
        $date_end=$this->input->post('date_end');
        $date_start=$this->input->post('date_start');

        $po_no=$this->input->post('po_no');
        if($po_no)
        {
            $po_no=intval($po_no);
            if(!($po_no>0))
            {
                $this->jsonReturn($items);
            }
        }
        $this->db->from($this->config->item('table_sales_po_details').' pod');

        $this->db->select('pod.*');


        $this->db->select('v.name variety_name');
        $this->db->select('crop_type.name crop_type_name');
        $this->db->select('crop.name crop_name');

        $this->db->join($this->config->item('table_sales_po').' po','po.id = pod.sales_po_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = po.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id =pod.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id =v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id =crop_type.crop_id','INNER');

        $this->db->where('pod.revision',1);
        $this->db->where('po.status_approved',$this->config->item('system_status_po_approval_approved'));


        if($po_no>0)
        {
            $this->db->where('po.id',$po_no);
        }
        else
        {
            if($date_end>0)
            {
                $this->db->where('po.date_approved <=',$date_end);
            }
            if($date_start>0)
            {
                $this->db->where('po.date_approved >=',$date_start);
            }
            if($warehouse_id>0)
            {
                $this->db->where('po.warehouse_id',$warehouse_id);
            }
            if($crop_id>0)
            {
                $this->db->where('crop.id',$crop_id);
            }
            if($crop_type_id>0)
            {
                $this->db->where('crop_type.id',$crop_type_id);
            }
            if($variety_id>0)
            {
                $this->db->where('pod.variety_id',$variety_id);
            }
            if($pack_size_id>0)
            {
                $this->db->where('pod.pack_size_id',$pack_size_id);
            }
            if($division_id>0)
            {
                $this->db->where('division.id',$division_id);
                if($zone_id>0)
                {
                    $this->db->where('zone.id',$zone_id);
                    if($territory_id>0)
                    {
                        $this->db->where('t.id',$territory_id);
                        if($district_id>0)
                        {
                            $this->db->where('d.id',$district_id);
                            if($customer_id>0)
                            {
                                $this->db->where('cus.id',$customer_id);
                            }
                        }
                    }
                }
            }
        }
        $this->db->order_by('crop.ordering,crop.id,crop_type.ordering,crop_type.id,v.ordering,v.id');
        $results=$this->db->get()->result_array();
        if(!$results)
        {
            $this->jsonReturn($items);
        }
        $varieties=array();
        foreach($results as $result)
        {
            $is_returned=$this->get_return_validity($date_start,$date_end,$result['date_return']);
            if(isset($varieties[$result['variety_id']][$result['pack_size_id']]))
            {
                //$info['total_po_quantity']=$info['po_quantity']=$info['actual_quantity']=$result['quantity'];
                $varieties[$result['variety_id']][$result['pack_size_id']]['total_po_quantity']+=$result['quantity'];
                $varieties[$result['variety_id']][$result['pack_size_id']]['po_quantity']+=$result['quantity'];
                $varieties[$result['variety_id']][$result['pack_size_id']]['actual_quantity']+=$result['quantity'];

                //$info['po_price']=$info['actual_price']=$result['quantity']*$result['variety_price'];
                $varieties[$result['variety_id']][$result['pack_size_id']]['po_price']+=($result['quantity']*$result['variety_price']);
                $varieties[$result['variety_id']][$result['pack_size_id']]['actual_price']+=($result['quantity']*$result['variety_price']);
                $info['return_quantity']=0;
                $info['bonus_quantity']=0;
                $info['bonus_return_quantity']=0;
                if($is_returned)
                {
                    $varieties[$result['variety_id']][$result['pack_size_id']]['return_quantity']+=$result['quantity_return'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['total_po_quantity']-=$result['quantity_return'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['actual_quantity']-=$result['quantity_return'];
                    $varieties[$result['variety_id']][$result['pack_size_id']]['actual_price']-=($result['quantity_return']*$result['variety_price']);
                }

            }
            else
            {
                $info=array();
                $info['crop_name']=$result['crop_name'];
                $info['crop_type_name']=$result['crop_type_name'];
                $info['variety_name']=$result['variety_name'];
                $info['pack_size']=$result['pack_size'];
                $info['total_po_quantity']=$info['po_quantity']=$info['actual_quantity']=$result['quantity'];
                $info['po_price']=$info['actual_price']=$result['quantity']*$result['variety_price'];
                $info['return_quantity']=0;
                $info['bonus_quantity']=0;
                $info['bonus_return_quantity']=0;
                if($is_returned)
                {
                    $info['return_quantity']+=$result['quantity_return'];
                    $info['total_po_quantity']-=$result['quantity_return'];
                    $info['actual_quantity']-=$result['quantity_return'];
                    $info['actual_price']-=($result['quantity_return']*$result['variety_price']);
                }
                $varieties[$result['variety_id']][$result['pack_size_id']]=$info;
            }
            if($result['bonus_pack_size_id']>0)
            {
                if(isset($varieties[$result['variety_id']][$result['bonus_pack_size_id']]))
                {
                    $varieties[$result['variety_id']][$result['bonus_pack_size_id']]['bonus_quantity']+=$result['quantity_bonus'];
                    $varieties[$result['variety_id']][$result['bonus_pack_size_id']]['total_po_quantity']+=$result['quantity_bonus'];
                    if($is_returned)
                    {
                        $varieties[$result['variety_id']][$result['bonus_pack_size_id']]['total_po_quantity']-=$result['quantity_bonus_return'];
                        $varieties[$result['variety_id']][$result['bonus_pack_size_id']]['bonus_return_quantity']+=$result['quantity_bonus_return'];

                    }

                }
                else
                {
                    $info=array();
                    $info['crop_name']=$result['crop_name'];
                    $info['crop_type_name']=$result['crop_type_name'];
                    $info['variety_name']=$result['variety_name'];
                    $info['pack_size']=$result['bonus_pack_size'];
                    $info['total_po_quantity']=$info['po_quantity']=$info['actual_quantity']=0;
                    $info['po_price']=$info['actual_price']=0;
                    $info['return_quantity']=0;
                    $info['bonus_quantity']=$result['quantity_bonus'];
                    $info['total_po_quantity']+=$result['quantity_bonus'];
                    $info['bonus_return_quantity']=0;
                    if($is_returned)
                    {
                        $info['total_po_quantity']-=$result['quantity_bonus_return'];
                        $info['bonus_return_quantity']+=$result['quantity_bonus_return'];

                    }
                    $varieties[$result['variety_id']][$result['bonus_pack_size_id']]=$info;
                }
            }


        }
        /*{ name: 'id', type: 'int' },
                { name: 'name', type: 'string' },
                { name: 'division_name', type: 'numeric' },
                { name: 'zone_name', type: 'string' },
                { name: 'territory_name', type: 'string' },
                { name: 'district_name', type: 'string' },
                { name: 'crop_name', type: 'string' },
                { name: 'crop_type_name', type: 'string' },
                { name: 'variety_name', type: 'string' },
                { name: 'pack_size', type: 'string' },
                { name: 'po_quantity', type: 'string' },
                { name: 'bonus_quantity', type: 'string' },
                { name: 'return_quantity', type: 'string' },
                { name: 'bonus_return_quantity', type: 'string' },
                { name: 'total_po_quantity', type: 'string' },
                { name: 'actual_quantity', type: 'string' },
                { name: 'po_price', type: 'string' },
                { name: 'actual_price', type: 'string' }*/
        $po_quantity_crop=0;

        $po_quantity_grand=0;
        $bonus_quantity_crop=0;

        $bonus_quantity_grand=0;
        $return_quantity_crop=0;

        $return_quantity_grand=0;
        $bonus_return_quantity_crop=0;

        $bonus_return_quantity_grand=0;
        $total_po_quantity_crop=0;

        $total_po_quantity_grand=0;
        $actual_quantity_crop=0;

        $actual_quantity_grand=0;
        $po_price_crop=0;

        $po_price_grand=0;
        $actual_price_crop=0;

        $actual_price_grand=0;


        $prev_crop_name='';
        $prev_crop_type_name='';
        $prev_variety_name='';

        $count=0;
        foreach($varieties as $variety)
        {
            foreach($variety as $pack)
            {
                if($count>0)
                {
                    if($prev_crop_name!=$pack['crop_name'])
                    {
                        $prev_crop_name=$pack['crop_name'];
                        $prev_crop_type_name=$pack['crop_type_name'];
                        $prev_variety_name=$pack['variety_name'];
                        $items[]=$this->get_total_sales_product_row('crop',$report_type,$po_quantity_crop,$bonus_quantity_crop,$return_quantity_crop,$bonus_return_quantity_crop,$total_po_quantity_crop,$actual_quantity_crop,$po_price_crop,$actual_price_crop);

                        $po_quantity_crop=0;
                        $bonus_quantity_crop=0;
                        $return_quantity_crop=0;
                        $bonus_return_quantity_crop=0;
                        $total_po_quantity_crop=0;
                        $actual_quantity_crop=0;
                        $po_price_crop=0;
                        $actual_price_crop=0;

                    }
                    elseif($prev_crop_type_name!=$pack['crop_type_name'])
                    {
                        $prev_crop_type_name=$pack['crop_type_name'];
                        $prev_variety_name=$pack['variety_name'];

                        $pack['crop_name']='';

                    }
                    elseif($prev_variety_name!=$pack['variety_name'])
                    {
                        $prev_variety_name=$pack['variety_name'];
                        $pack['crop_name']='';
                        $pack['crop_type_name']='';

                    }
                    else
                    {
                        $pack['crop_name']='';
                        $pack['crop_type_name']='';
                        $pack['variety_name']='';

                    }
                }
                else
                {
                    $prev_crop_name=$pack['crop_name'];
                    $prev_crop_type_name=$pack['crop_type_name'];
                    $prev_variety_name=$pack['variety_name'];

                }
                $count++;
                if($report_type=='weight')
                {
                    $po_quantity_crop+=$pack['po_quantity']*$pack['pack_size'];

                    $po_quantity_grand+=$pack['po_quantity']*$pack['pack_size'];
                    $bonus_quantity_crop+=$pack['bonus_quantity']*$pack['pack_size'];

                    $bonus_quantity_grand+=$pack['bonus_quantity']*$pack['pack_size'];
                    $return_quantity_crop+=$pack['return_quantity']*$pack['pack_size'];

                    $return_quantity_grand+=$pack['return_quantity']*$pack['pack_size'];
                    $bonus_return_quantity_crop+=$pack['bonus_return_quantity']*$pack['pack_size'];

                    $bonus_return_quantity_grand+=$pack['bonus_return_quantity']*$pack['pack_size'];
                    $total_po_quantity_crop+=$pack['total_po_quantity']*$pack['pack_size'];

                    $total_po_quantity_grand+=$pack['total_po_quantity']*$pack['pack_size'];
                    $actual_quantity_crop+=$pack['actual_quantity']*$pack['pack_size'];

                    $actual_quantity_grand+=$pack['actual_quantity']*$pack['pack_size'];
                }
                else
                {
                    $po_quantity_crop+=$pack['po_quantity'];

                    $po_quantity_grand+=$pack['po_quantity'];
                    $bonus_quantity_crop+=$pack['bonus_quantity'];

                    $bonus_quantity_grand+=$pack['bonus_quantity'];
                    $return_quantity_crop+=$pack['return_quantity'];

                    $return_quantity_grand+=$pack['return_quantity'];
                    $bonus_return_quantity_crop+=$pack['bonus_return_quantity'];

                    $bonus_return_quantity_grand+=$pack['bonus_return_quantity'];
                    $total_po_quantity_crop+=$pack['total_po_quantity'];

                    $total_po_quantity_grand+=$pack['total_po_quantity'];
                    $actual_quantity_crop+=$pack['actual_quantity'];

                    $actual_quantity_grand+=$pack['actual_quantity'];

                }
                $po_price_crop+=$pack['po_price'];

                $po_price_grand+=$pack['po_price'];
                $actual_price_crop+=$pack['actual_price'];

                $actual_price_grand+=$pack['actual_price'];


                $items[]=$this->get_sales_product_row($report_type,$pack);
            }
        }
        $items[]=$this->get_total_sales_product_row('crop',$report_type,$po_quantity_crop,$bonus_quantity_crop,$return_quantity_crop,$bonus_return_quantity_crop,$total_po_quantity_crop,$actual_quantity_crop,$po_price_crop,$actual_price_crop);
        $items[]=$this->get_total_sales_product_row('grand',$report_type,$po_quantity_grand,$bonus_quantity_grand,$return_quantity_grand,$bonus_return_quantity_grand,$total_po_quantity_grand,$actual_quantity_grand,$po_price_grand,$actual_price_grand);


        $this->jsonReturn($items);
    }
    private function get_total_sales_product_row($total_type,$report_type,$po_quantity,$bonus_quantity,$return_quantity,$bonus_return_quantity,$total_po_quantity,$actual_quantity,$po_price,$actual_price)
    {
        $info=array();
        $info['crop_name']='';
        if($total_type=='grand')
        {
            $info['crop_name']='Grand Total';
        }
        $info['crop_type_name']='';
        if($total_type=='crop')
        {
            $info['crop_type_name']='Crop Total';
        }
        $info['variety_name']='';
        $info['pack_size']='';
        if($report_type=='weight')
        {
            $info['po_quantity']=number_format($po_quantity/1000,3,'.','');
            $info['bonus_quantity']=number_format($bonus_quantity/1000,3,'.','');
            $info['return_quantity']=number_format($return_quantity/1000,3,'.','');
            $info['bonus_return_quantity']=number_format($bonus_return_quantity/1000,3,'.','');
            $info['total_po_quantity']=number_format($total_po_quantity/1000,3,'.','');
            $info['actual_quantity']=number_format($actual_quantity/1000,3,'.','');
        }
        else
        {
            $info['po_quantity']=$po_quantity;
            $info['bonus_quantity']=$bonus_quantity;
            $info['return_quantity']=$return_quantity;
            $info['bonus_return_quantity']=$bonus_return_quantity;
            $info['total_po_quantity']=$total_po_quantity;
            $info['actual_quantity']=$actual_quantity;
        }

        $info['po_price']=number_format($po_price,2);
        $info['actual_price']=number_format($actual_price,2);
        return $info;
    }
    private function get_sales_product_row($report_type,$info)
    {

        $row=array();
        $row['crop_name']=$info['crop_name'];
        $row['crop_type_name']=$info['crop_type_name'];
        $row['variety_name']=$info['variety_name'];
        $row['pack_size']=$info['pack_size'];
        $row['po_quantity']=$info['po_quantity'];
        $row['bonus_quantity']=$info['bonus_quantity'];
        $row['return_quantity']=$info['return_quantity'];
        $row['bonus_return_quantity']=$info['bonus_return_quantity'];
        $row['total_po_quantity']=$info['total_po_quantity'];
        $row['actual_quantity']=$info['actual_quantity'];
        $row['po_price']=number_format($info['po_price'],2);
        $row['actual_price']=number_format($info['actual_price'],2);
        if($report_type=='weight')
        {
            $row['po_quantity']=number_format($info['po_quantity']*$info['pack_size']/1000,3,'.','');
            $row['bonus_quantity']=number_format($info['bonus_quantity']*$info['pack_size']/1000,3,'.','');
            $row['return_quantity']=number_format($info['return_quantity']*$info['pack_size']/1000,3,'.','');
            $row['bonus_return_quantity']=number_format($info['bonus_return_quantity']*$info['pack_size']/1000,3,'.','');
            $row['total_po_quantity']=number_format($info['total_po_quantity']*$info['pack_size']/1000,3,'.','');
            $row['actual_quantity']=number_format($info['actual_quantity']*$info['pack_size']/1000,3,'.','');
        }
        return $row;
    }
}
