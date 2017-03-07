<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_fd_management extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public $locations;

    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Reports_fd_management');
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
        $this->controller_url='reports_fd_management';
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
        elseif($action=='details')
        {
            $this->system_details($id);
        }
        elseif($action=="get_items")
        {
            $this->system_get_items();
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
            $data['title']="Field Day Report Search";
            $ajax['status']=true;
            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['zones']=array();
            $data['territories']=array();
            $data['districts']=array();
            $data['upazillas']=array();
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
                            $data['upazillas']=Query_helper::get_info($this->config->item('table_setup_location_upazillas'),array('id value','name text'),array('district_id ='.$this->locations['district_id'],'status ="'.$this->config->item('system_status_active').'"'));
                        }
                    }
                }
            }
            $data['crops']=Query_helper::get_info($this->config->item('table_setup_classification_crops'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));

            $fiscal_years=Query_helper::get_info($this->config->item('table_basic_setup_fiscal_year'),'*',array());
            $data['fiscal_years']=array();
            foreach($fiscal_years as $year)
            {
                $data['fiscal_years'][]=array('text'=>$year['name'],'value'=>System_helper::display_date($year['date_start']).'/'.System_helper::display_date($year['date_end']));
            }

            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/search",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url);
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
            else
            {
                $reports['date_end']=time();
            }
            //print_r($reports);exit;
            if($reports['date_start']>$reports['date_end'])
            {
                $ajax['status']=false;
                $ajax['system_message']='Start Date Must be less than End Date';
                $this->jsonReturn($ajax);
            }

            $keys=',';

            foreach($reports as $elem=>$value)
            {
                $keys.=$elem.":'".$value."',";
            }
            $data['keys']=trim($keys,',');
            $ajax['status']=true;
            $data['title']="Field Day Report";
            $ajax['system_content'][]=array("id"=>"#system_report_container","html"=>$this->load->view($this->controller_url."/list",$data,true));

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
    private function system_details($id)
    {
        $budget_id=$this->input->post('id');
        $html_container_id=$this->input->post('html_container_id');
        $data=array();
        $this->db->from($this->config->item('table_tm_fd_bud_info_details').' fdb_details');
        $this->db->select('fdb_details.*');
        $this->db->select('fdb.*');
        $this->db->select('v.name variety_name');
        $this->db->select('v1.name com_variety_name');
        $this->db->select('crop.name crop_name,crop.id crop_id');
        $this->db->select('type.name crop_type_name,type.id crop_type_id');
        $this->db->select('u.name upazilla_name');
        $this->db->select('d.name district_name,d.id district_id');
        $this->db->select('t.name territory_name,t.id territory_id');
        $this->db->select('zone.name zone_name,zone.id zone_id');
        $this->db->select('division.name division_name,division.id division_id');

        $this->db->join($this->config->item('table_tm_fd_bud_budget').' fdb','fdb.id = fdb_details.budget_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id = fdb_details.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' type','type.id = v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id = type.crop_id','INNER');
        $this->db->join($this->config->item('table_setup_location_upazillas').' u','u.id = fdb_details.upazilla_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = u.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_varieties').' v1','v1.id = fdb_details.competitor_variety_id','LEFT');
        $this->db->where('fdb_details.budget_id',$budget_id);
        $this->db->where('fdb_details.revision',1);
        $data['item_info']=$this->db->get()->row_array();

        $data['report_item']=Query_helper::get_info($this->config->item('table_tm_fd_bud_reporting'),'*',array('budget_id ='.$budget_id));
        $user_ids=array();
        $info_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_info'),'*',array('budget_id ='.$budget_id,'revision=1'));
        foreach($info_details as $info)
        {
            $data['info']=$info;
            $user_ids[$info['user_created']]=$info['user_created'];
        }
        //get user info from login site
        $data['user_info']=System_helper::get_users_info($user_ids);

        $results=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text','status'),array(),0,0,array('ordering ASC'));
        foreach($results as $result)
        {
            $data['expense_items'][$result['value']]=$result;
        }
        $data['expense_budget']=array();
        $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_expense'),'*',array('budget_id ='.$budget_id,'revision=1'));
        foreach($results as $result)
        {
            $data['expense_budget'][$result['item_id']]=$result;
        }
        $data['expense_report']=array();
        $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_expense'),'*',array('budget_id ='.$budget_id,'revision=1'));
        foreach($results as $res)
        {
            $data['expense_report'][$res['item_id']]=$res;
        }

        $results=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','name text','phone_no','status'),array('upazilla_id ='.$data['item_info']['upazilla_id']),0,0,array('ordering ASC'));
        $data['leading_farmers']=array();
        foreach($results as $result)
        {
            $data['leading_farmers'][$result['value']]=$result;
        }
        $data['participants']=array();
        $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_participant'),'*',array('budget_id ='.$budget_id,'revision=1'));
        foreach($results as $res)
        {
            $data['participants'][$res['farmer_id']]=$res;
        }
        $data['farmers']=array();
        $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_participant'),'*',array('budget_id ='.$budget_id,'revision=1'));
        foreach($results as $res)
        {
            $data['farmers'][$res['farmer_id']]=$res;
        }

        $result=Query_helper::get_info($this->config->item('table_tm_fd_bud_reporting'),'*',array('budget_id ='.$budget_id));
        foreach($result as $res)
        {
            $data['item']['date']=$res['date'];
            $data['item']['date_of_fd']=$res['date_of_fd'];
            $data['item']['recommendation']=$res['recommendation'];
        }

        $this->db->from($this->config->item('table_tm_fd_rep_details_info').' fr_details');
        $this->db->select('fr_details.*');
        $this->db->where('fr_details.budget_id',$budget_id);
        $this->db->where('fr_details.revision',1);
        $data['new_item']=$this->db->get()->row_array();

        $data['picture_categories']=Query_helper::get_info($this->config->item('table_setup_fd_bud_picture_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1','status ="'.$this->config->item('system_status_active').'"'));
        foreach($results as $result)
        {
            $data['b_fd_file_details'][$result['item_id']]=$result;
        }

        $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1'));
        foreach($results as $result)
        {
            if(substr($result['file_type'],0,5)=='image')
            {
                $data['a_fd_file_details'][]=$result;
            }
            elseif(substr($result['file_type'],0,5)=='video')
            {
                $data['video_file_details']=$result;
            }
        }

        $ajax['status']=true;
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view($this->controller_url.'/details',$data,true));
        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }
        $ajax['status']=true;
        $this->jsonReturn($ajax);
    }

    private function system_get_items()
    {
        $items=array();
        $division_id=$this->input->post('division_id');
        $zone_id=$this->input->post('zone_id');
        $territory_id=$this->input->post('territory_id');
        $district_id=$this->input->post('district_id');
        $upazilla_id=$this->input->post('upazilla_id');
        $crop_id=$this->input->post('crop_id');
        $crop_type_id=$this->input->post('crop_type_id');
        $variety_id=$this->input->post('variety_id');
        $date_start=$this->input->post('date_start');
        $date_end=$this->input->post('date_end');

        $this->db->from($this->config->item('table_tm_fd_rep_details_info').' frdi');
        $this->db->select('frdi.*');
        $this->db->select('fbr.*');
        $this->db->select('fbid.*');
        $this->db->select('v.name variety_name');
        $this->db->select('crop.name crop_name');
        $this->db->select('type.name crop_type_name');
        $this->db->select('u.name upazilla_name');
        $this->db->select('d.name district_name');
        $this->db->select('t.name territory_name');
        $this->db->select('zone.name zone_name');
        $this->db->select('division.name division_name');

        $this->db->join($this->config->item('table_tm_fd_bud_reporting').' fbr','fbr.budget_id = frdi.budget_id','INNER');
        $this->db->join($this->config->item('table_tm_fd_bud_info_details').' fbid','fbid.budget_id = fbr.budget_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id = fbid.variety_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crop_types').' type','type.id = v.crop_type_id','INNER');
        $this->db->join($this->config->item('table_setup_classification_crops').' crop','crop.id = type.crop_id','INNER');
        $this->db->join($this->config->item('table_setup_location_upazillas').' u','u.id = fbid.upazilla_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = u.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');

        if($crop_id>0)
        {
            $this->db->where('type.crop_id',$crop_id);
            if($crop_type_id>0)
            {
                $this->db->where('type.id',$crop_type_id);
                if($variety_id>0)
                {
                    $this->db->where('v.id',$variety_id);
                }
            }
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
                        if($upazilla_id>0)
                        {
                            $this->db->where('u.id',$upazilla_id);
                        }
                    }
                }
            }
        }
        if($date_start>0)
        {
            $this->db->where('fbr.date_of_fd >=',$date_start);
        }
        if($date_end>0)
        {
            $this->db->where('fbr.date_of_fd <=',$date_end);
        }
        $this->db->where('fbid.revision',1);
        $this->db->where('frdi.revision',1);
        $this->db->order_by('fbr.date_of_fd DESC');
        $results=$this->db->get()->result_array();
        if(!$results)
        {
            $this->jsonReturn($items);
        }

        foreach($results as $result)
        {
            $item=array();
            $item['id']=$result['budget_id'];
            $item['date_of_fd']=System_helper::display_date($result['date_of_fd']);
            $item['crop_info']=$result['crop_name'].'<br>'.$result['crop_type_name'].'<br>'.$result['variety_name'];
            $item['location_info']=$result['division_name'].'<br>'.$result['zone_name'].'<br>'.$result['territory_name'].'<br>'.$result['district_name'].'<br>'.$result['upazilla_name'];
            $item['total_participant']=$result['total_participant'];
            $item['total_expense']=$result['total_expense'];
            $item['sales_target']=$result['next_sales_target'];
            $item['recommendation']=$result['recommendation'];

            $item['details']['crop_name']=$result['crop_name'];
            $item['details']['crop_type_name']=$result['crop_type_name'];
            $item['details']['variety_name']=$result['variety_name'];

            $items[]=$item;
        }
        $this->jsonReturn($items);
    }

} 