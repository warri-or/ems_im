<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tm_fd_bud_request extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Tm_fd_bud_request');
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
        $this->permissions['request_approve']=1;
        if($this->locations['territory_id']>0)
        {
            $this->permissions['request_approve']=0;
        }
        $this->controller_url='tm_fd_bud_request';
    }

    public function index($action="list",$id=0)
    {
        if($action=="list")
        {
            $this->system_list();
        }
        if($action=="get_items")
        {
            $this->system_get_items();
        }
        elseif($action=="edit")
        {
            $this->system_edit($id);
        }
        elseif($action=="save")
        {
            $this->system_save();
        }
        elseif($action=="details")
        {
            $this->system_details($id);
        }
        elseif($action=="request")
        {
            $this->system_request($id);
        }
        elseif($action=="save_request")
        {
            $this->system_save_request();
        }
        else
        {
            $this->system_list();
        }
    }

    private function system_list()
    {
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            $data['title']="Field Day Budget List";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/list",$data,true));
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

    private function system_get_items()
    {
        $this->db->from($this->config->item('table_tm_fd_bud_info_details').' fdb_details');
        $this->db->select('fdb_details.*');
        $this->db->select('fdb.*');
        $this->db->select('v.name variety_name');
        $this->db->select('v1.name com_variety_name');
        $this->db->select('crop.name crop_name');
        $this->db->select('type.name crop_type_name');
        $this->db->select('u.name upazilla_name');
        $this->db->select('d.name district_name');
        $this->db->select('t.name territory_name');
        $this->db->select('zone.name zone_name');
        $this->db->select('division.name division_name');

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

        if($this->locations['division_id']>0)
        {
            $this->db->where('division.id',$this->locations['division_id']);
            if($this->locations['zone_id']>0)
            {
                $this->db->where('zone.id',$this->locations['zone_id']);
                if($this->locations['territory_id']>0)
                {
                    $this->db->where('t.id',$this->locations['territory_id']);
                    if($this->locations['district_id']>0)
                    {
                        $this->db->where('d.id',$this->locations['district_id']);
                        if($this->locations['upazilla_id']>0)
                        {
                            $this->db->where('u.id',$this->locations['upazilla_id']);
                        }
                    }
                }
            }
        }
        $this->db->where('fdb_details.revision',1);
        $this->db->group_by('fdb.id');
        $this->db->order_by('fdb.id','DESC');
        $items=$this->db->get()->result_array();

        foreach($items as &$item)
        {
            $item['date']=System_helper::display_date($item['date']);
            $item['expected_date']=System_helper::display_date($item['expected_date']);

        }
        $this->jsonReturn($items);
    }


    private function system_edit($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $budget_id=$this->input->post('id');
            }
            else
            {
                $budget_id=$id;
            }

            $this->db->from($this->config->item('table_tm_fd_bud_info_details').' fdb_details');
            $this->db->select('fdb_details.*');
            $this->db->select('fdb.*');
            $this->db->select('variety.crop_type_id');
            $this->db->select('crop_type.crop_id');
            $this->db->select('u.district_id');
            $this->db->select('d.territory_id');
            $this->db->select('t.zone_id zone_id');
            $this->db->select('zone.division_id division_id');

            $this->db->join($this->config->item('table_tm_fd_bud_budget').' fdb','fdb.id = fdb_details.budget_id','INNER');
            $this->db->join($this->config->item('table_setup_classification_varieties').' variety','variety.id = fdb_details.variety_id','INNER');
            $this->db->join($this->config->item('table_setup_classification_crop_types').' crop_type','crop_type.id = variety.crop_type_id','INNER');
            $this->db->join($this->config->item('table_setup_location_upazillas').' u','u.id = fdb_details.upazilla_id','INNER');
            $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = u.district_id','INNER');
            $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
            $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
            $this->db->where('fdb_details.budget_id',$budget_id);
            $this->db->where('fdb_details.revision',1);
            $data['item_info']=$this->db->get()->row_array();
            $data['item']['date']=$data['item_info']['date'];
            $data['item']['remarks']=$data['item_info']['remarks'];
            $data['item']['id']=$data['item_info']['id'];

            if(!$data['item_info'])
            {
                System_helper::invalid_try($this->config->item('system_edit_not_exists'),$budget_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if(!$this->check_my_editable($data['item_info']))
            {
                System_helper::invalid_try($this->config->item('system_edit_others'),$budget_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if($data['item_info']['status_requested']==$this->config->item('system_status_po_request_requested'))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_FDB_EDIT_UNABLE");
                $this->jsonReturn($ajax);
            }
            if($data['item_info']['status_requested']==$this->config->item('system_status_po_request_rejected'))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_FDB_EDIT_UNABLE_FOR_REJECT");
                $this->jsonReturn($ajax);
            }

            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['zones']=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('division_id ='.$data['item_info']['division_id']));
            $data['territories']=Query_helper::get_info($this->config->item('table_setup_location_territories'),array('id value','name text'),array('zone_id ='.$data['item_info']['zone_id']));
            $data['districts']=Query_helper::get_info($this->config->item('table_setup_location_districts'),array('id value','name text'),array('territory_id ='.$data['item_info']['territory_id']));
            $data['upazillas']=Query_helper::get_info($this->config->item('table_setup_location_upazillas'),array('id value','name text'),array('district_id ='.$data['item_info']['district_id']));

            $data['crops']=Query_helper::get_info($this->config->item('table_setup_classification_crops'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['crop_types']=Query_helper::get_info($this->config->item('table_setup_classification_crop_types'),array('id value','name text'),array('crop_id ='.$data['item_info']['crop_id']));
            $data['crop_varieties']=Query_helper::get_info($this->config->item('table_setup_classification_varieties'),array('id value','name text'),array('crop_type_id ='.$data['item_info']['crop_type_id']));
            $data['competitor_varieties']=Query_helper::get_info($this->config->item('table_setup_classification_varieties'),array('id value','name text'),array('crop_type_id ='.$data['item_info']['crop_type_id'],'whose ="Competitor"'));

            $data['expense_items']=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['expense_budget']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_expense'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                $data['expense_budget'][$result['item_id']]=$result;
            }

            $data['leading_farmers']=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','name text','phone_no phone_no'),array('status ="'.$this->config->item('system_status_active').'"','upazilla_id ='.$data['item_info']['upazilla_id']));
            $data['participants']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_participant'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                $data['participants'][$result['farmer_id']]=$result;
            }

            $data['picture_categories']=Query_helper::get_info($this->config->item('table_setup_fd_bud_picture_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['file_details']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1','status ="'.$this->config->item('system_status_active').'"'));
            foreach($results as $result)
            {
                $data['file_details'][$result['item_id']]=$result;
            }

            $data['title']="Edit Field Day Budget";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$budget_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function check_my_editable($security)
    {
        if(($this->locations['division_id']>0)&&($this->locations['division_id']!=$security['division_id']))
        {
            return false;
        }
        if(($this->locations['zone_id']>0)&&($this->locations['zone_id']!=$security['zone_id']))
        {
            return false;
        }
        if(($this->locations['territory_id']>0)&&($this->locations['territory_id']!=$security['territory_id']))
        {
            return false;
        }
        if(($this->locations['district_id']>0)&&($this->locations['district_id']!=$security['district_id']))
        {
            return false;
        }
        return true;
    }


    private function system_save()
    {
        $id = $this->input->post("id");
        $user = User_helper::get_user();
        if($id>0)
        {
            if(!(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        else
        {
            if(!(isset($this->permissions['add'])&&($this->permissions['add']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $time=time();
            $field_budget=$this->input->post('item');
            $field_budget['date']=System_helper::get_time($field_budget['date']);
            $field_budget_details=$this->input->post('item_info');
            $field_budget_details['expected_date']=System_helper::get_time($field_budget_details['expected_date']);
            $field_budget_details['total_budget']=0;
            $participants=$this->input->post('farmer_participant');
            foreach($participants as &$no_of_participant)
            {
                if($no_of_participant=='')
                {
                    $no_of_participant=0;
                }
            }

            $expense_budget=$this->input->post('expense_budget');
            foreach($expense_budget as $amount)
            {
                if($amount>0)
                {
                    $field_budget_details['total_budget']+=$amount;
                }
            }
            $this->db->trans_begin();  //DB Transaction Handle START
            if($id>0)
            {
                $budget_id=$id;
                $field_budget['user_updated'] = $user->user_id;
                $field_budget['date_updated'] = $time;
                Query_helper::update($this->config->item('table_tm_fd_bud_budget'),$field_budget,array("id = ".$id));
            }
            else
            {
                $field_budget['user_created'] = $user->user_id;
                $field_budget['date_created'] = $time;
                $budget_id=Query_helper::add($this->config->item('table_tm_fd_bud_budget'),$field_budget);
                if($budget_id===false)
                {
                    $this->db->trans_rollback();
                    $ajax['status']=false;
                    $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                    $this->jsonReturn($ajax);
                    die();
                }
                else
                {
                    $budget_id=$budget_id;
                }
            }
            //budget details start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_bud_info_details'));
            $field_budget_details['budget_id']=$budget_id;
            $field_budget_details['revision']=1;
            $field_budget_details['user_created'] = $user->user_id;
            $field_budget_details['date_created'] = $time;
            Query_helper::add($this->config->item('table_tm_fd_bud_info_details'),$field_budget_details);
            //budget details end

            //expense items start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_bud_details_expense'));
            foreach($expense_budget as $item_id=>$amount)
            {
                $data=array();
                $data['budget_id']=$budget_id;
                $data['item_id']=$item_id;
                $data['amount']=0;
                if($amount>0)
                {
                    $data['amount']=$amount;
                }
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                $data['revision']=1;
                Query_helper::add($this->config->item('table_tm_fd_bud_details_expense'),$data);
            }
            //expense items end

            //participant though leading farmer details start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_bud_details_participant'));
            foreach($participants as $farmer_id=>$number)
            {
                $data=array();
                $data['budget_id']=$budget_id;
                $data['farmer_id']=$farmer_id;
                $data['number']=$number;
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                $data['revision']=1;
                Query_helper::add($this->config->item('table_tm_fd_bud_details_participant'),$data);
            }
            //participant though leading farmer details end

            //file details start
            $image_info=$this->input->post('image_info');

            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_bud_details_picture'));
            $file_folder='images/field_day/'.$budget_id;
            $dir=(FCPATH).$file_folder;
            if(!is_dir($dir))
            {
                mkdir($dir, 0777);
            }
            //$types='gif|jpg|png|jpeg';
            $uploaded_files = System_helper::upload_file($file_folder);
            foreach($uploaded_files as $file)
            {
                if(!$file['status'])
                {
                    $this->db->trans_rollback();
                    $ajax['status']=false;
                    $ajax['system_message']=$file['message'];
                    $this->jsonReturn($ajax);
                    die();
                }
            }
            $arm_file_details_remarks=$this->input->post('arm_file_details_remarks');
            $com_file_details_remarks=$this->input->post('com_file_details_remarks');
            foreach($arm_file_details_remarks as $item_id=>$remarks)
            {
                $data=array();
                $data['budget_id']=$budget_id;
                $data['item_id']=$item_id;
                if(isset($uploaded_files['arm_'.$item_id]))
                {
                    $data['arm_file_location']=$file_folder.'/'.$uploaded_files['arm_'.$item_id]['info']['file_name'];
                    $data['arm_file_name']=$uploaded_files['arm_'.$item_id]['info']['file_name'];
                }
                else
                {
                    $data['arm_file_location']=$image_info[$item_id]['arm_file_location'];
                    $data['arm_file_name']=$image_info[$item_id]['arm_file_name'];
                }
                if(isset($uploaded_files['competitor_'.$item_id]))
                {
                    $data['competitor_file_location']=$file_folder.'/'.$uploaded_files['competitor_'.$item_id]['info']['file_name'];
                    $data['competitor_file_name']=$uploaded_files['competitor_'.$item_id]['info']['file_name'];
                }
                else
                {
                    $data['competitor_file_location']=$image_info[$item_id]['competitor_file_location'];
                    $data['competitor_file_name']=$image_info[$item_id]['competitor_file_name'];
                }
                $data['arm_file_remarks']=$remarks;
                $data['competitor_file_remarks']=$com_file_details_remarks[$item_id];
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                $data['revision']=1;
                Query_helper::add($this->config->item('table_tm_fd_bud_details_picture'),$data);
            }
            //file details start

            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $save_and_new=$this->input->post('system_save_new_status');
                $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
                if($save_and_new==1)
                {
                    $this->system_add();
                }
                else
                {
                    $this->system_list();
                }
            }
            else
            {
                $this->db->trans_rollback();
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }
        }

    }

    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item[date]',$this->lang->line('LABEL_DATE'),'required');
        $this->form_validation->set_rules('item_info[variety_id]',$this->lang->line('LABEL_VARIETY_NAME'),'required');
        $this->form_validation->set_rules('item_info[upazilla_id]',$this->lang->line('LABEL_UPAZILLA_NAME'),'required');
        $this->form_validation->set_rules('item_info[address]',$this->lang->line('LABEL_ADDRESS'),'required');
        $this->form_validation->set_rules('item_info[present_condition]',$this->lang->line('LABEL_PRESENT_CONDITION'),'required');
        $this->form_validation->set_rules('item_info[farmers_evaluation]',$this->lang->line('LABEL_FARMERS_EVALUATION'),'required');
        $this->form_validation->set_rules('item_info[sales_target]',$this->lang->line('LABEL_NEXT_SALES_TARGET'),'required|numeric');
        $this->form_validation->set_rules('item_info[no_of_participant]',$this->lang->line('LABEL_EXPECTED_PARTICIPANT'),'required|numeric');
        $this->form_validation->set_rules('item_info[diff_wth_com]',$this->lang->line('LABEL_SPECIFIC_DIFFERENCE'),'required');
        $this->form_validation->set_rules('item_info[expected_date]',$this->lang->line('LABEL_EXPECTED_DATE'),'required');
        $this->form_validation->set_rules('item[remarks]',$this->lang->line('LABEL_RECOMMENDATION'),'required');

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }

    private function system_details($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $budget_id=$this->input->post('id');
            }
            else
            {
                $budget_id=$id;
            }
            $this->db->from($this->config->item('table_tm_fd_bud_info_details').' fdb_details');
            $this->db->select('fdb_details.*');
            $this->db->select('fdb.*');
            $this->db->select('v.name variety_name');
            $this->db->select('v1.name com_variety_name');
            $this->db->select('crop.name crop_name');
            $this->db->select('type.name crop_type_name');
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
            if(!$data['item_info'])
            {
                System_helper::invalid_try($this->config->item('system_edit_not_exists'),$budget_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if(!$this->check_my_editable($data['item_info']))
            {
                System_helper::invalid_try($this->config->item('system_edit_others'),$budget_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            $user_ids=array();
            $user_ids[$data['item_info']['user_created']]=$data['item_info']['user_created'];
            if($data['item_info']['user_requested']>0)
            {
                $user_ids[$data['item_info']['user_requested']]=$data['item_info']['user_requested'];
            }
            if($data['item_info']['user_approved']>0)
            {
                $user_ids[$data['item_info']['user_approved']]=$data['item_info']['user_approved'];
            }
            $data['users']=System_helper::get_users_info($user_ids);


            $this->db->from($this->config->item('table_tm_fd_bud_info_details').' fbid');
            $this->db->select('fbid.*');
            //$this->db->join($this->config->item('table_tm_fd_bud_budget').' fbb','fbb.id =fbid.budget_id','INNER');
            $this->db->where('fbid.budget_id',$budget_id);
            $this->db->order_by('fbid.revision ASC');
            $this->db->order_by('fbid.id DESC');
            //details
            $info_details=$this->db->get()->result_array();
            $data['info_details']=array();
            foreach($info_details as $info)
            {
                $data['info_details'][$info['revision']][]=$info;
                $user_ids[$info['user_created']]=$info['user_created'];
            }
            //get user info from login site
            $data['users_info']=System_helper::get_users_info($user_ids);

            //expense
            $this->db->from($this->config->item('table_tm_fd_bud_details_expense').' fbde');
            $this->db->select('fbde.*');
            //$this->db->join($this->config->item('table_tm_fd_bud_budget').' fbb','fbb.id =fbde.budget_id','INNER');
            $this->db->where('fbde.budget_id',$budget_id);
            $this->db->order_by('fbde.revision ASC');
            $this->db->order_by('fbde.id DESC');
            $expense_details=$this->db->get()->result_array();
            $data['expense_details']=array();
            foreach($expense_details as $expense)
            {
                $data['expense_details'][$expense['revision']][]=$expense;
            }
            //participant through leading farmers
            $this->db->from($this->config->item('table_tm_fd_bud_details_participant').' fbdp');
            $this->db->select('fbdp.*');
            //$this->db->join($this->config->item('table_tm_fd_bud_budget').' fbb','fbb.id =fbdp.budget_id','INNER');
            $this->db->where('fbdp.budget_id',$budget_id);
            $this->db->order_by('fbdp.revision ASC');
            $this->db->order_by('fbdp.id ASC');
            $participant_details=$this->db->get()->result_array();
            $data['participant_details']=array();
            foreach($participant_details as $participant)
            {
                $data['participant_details'][$participant['revision']][]=$participant;
            }

            $data['expense_items']=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['leading_farmers']=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','name text','phone_no phone_no'),array('status ="'.$this->config->item('system_status_active').'"','upazilla_id ='.$data['item_info']['upazilla_id']));
            $data['picture_categories']=Query_helper::get_info($this->config->item('table_setup_fd_bud_picture_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));

            $data['file_details']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1','status ="'.$this->config->item('system_status_active').'"'));
            foreach($results as $result)
            {
                $data['file_details'][$result['item_id']]=$result;
            }

            $data['title']='Field Day Budget Details';
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$budget_id);
            $this->jsonReturn($ajax);
        }
        else
        {

            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_request($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $budget_id=$this->input->post('id');
            }
            else
            {
                $budget_id=$id;
            }

            $this->db->from($this->config->item('table_tm_fd_bud_info_details').' fdb_details');
            $this->db->select('fdb_details.*');
            $this->db->select('fdb.*');
            $this->db->select('v.name variety_name');
            $this->db->select('v1.name com_variety_name');
            $this->db->select('crop.name crop_name');
            $this->db->select('type.name crop_type_name');
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
            if(!$data['item_info'])
            {
                System_helper::invalid_try($this->config->item('system_edit_not_exists'),$budget_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if(!$this->check_my_editable($data['item_info']))
            {
                System_helper::invalid_try($this->config->item('system_edit_others'),$budget_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if($data['item_info']['status_requested']==$this->config->item('system_status_po_request_requested'))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_FDB_REQUESTED_UNABLE");
                $this->jsonReturn($ajax);
            }
            if($data['item_info']['status_requested']==$this->config->item('system_status_po_request_rejected'))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_FDB_EDIT_UNABLE_FOR_REJECT");
                $this->jsonReturn($ajax);
            }

            $data['expense_items']=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['expense_budget']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_expense'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                $data['expense_budget'][$result['item_id']]=$result;
            }

            $data['leading_farmers']=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','name text','phone_no phone_no'),array('status ="'.$this->config->item('system_status_active').'"','upazilla_id ='.$data['item_info']['upazilla_id']));
            $data['participants']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_participant'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                $data['participants'][$result['farmer_id']]=$result;
            }

            $data['picture_categories']=Query_helper::get_info($this->config->item('table_setup_fd_bud_picture_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['file_details']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1','status ="'.$this->config->item('system_status_active').'"'));
            foreach($results as $result)
            {
                $data['file_details'][$result['item_id']]=$result;
            }

            $data['title']='Request to Field Day Budget';
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/request",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/request/'.$budget_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_save_request()
    {
        $id = $this->input->post("id");
        $user = User_helper::get_user();
        if(!(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
            die();
        }
        if(!$this->check_validation_request())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $time=time();

            $data=$this->input->post('request');
            $data['user_requested'] = $user->user_id;
            $data['date_requested'] = $time;
            $this->db->trans_start();  //DB Transaction Handle START

            Query_helper::update($this->config->item('table_tm_fd_bud_budget'),$data,array("id = ".$id));

            $this->db->trans_complete();   //DB Transaction Handle END
            if ($this->db->trans_status() === TRUE)
            {
                $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
                $this->system_list();
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }
        }
    }

    private function check_validation_request()
    {
        $data=$this->input->post('request');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('request[remarks_requested]',$this->lang->line('LABEL_RECOMMENDATION'),'required');
        if(!(($data['status_requested']==$this->config->item('system_status_po_request_requested'))||($data['status_requested']==$this->config->item('system_status_po_approval_rejected'))))
        {
            $this->message="Please Select Request or Reject";
            return false;
        }
        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
} 