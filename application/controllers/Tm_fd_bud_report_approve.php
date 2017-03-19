<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 3/19/17
 * Time: 10:03 AM
 */

class Tm_fd_bud_report_approve extends Root_Controller {

    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Tm_fd_bud_report_approve');
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
        $this->permissions['report_approve']=1;
        if($this->locations['territory_id']>0)
        {
            $this->permissions['report_approve']=0;
        }
        $this->controller_url='tm_fd_bud_report_approve';
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
        elseif($action=="details")
        {
            $this->system_details($id);
        }
        elseif($action=="approve")
        {
            $this->system_approve($id);
        }
        elseif($action=="save_approval")
        {
            $this->system_save_approval();
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
            $data['title']="Field Day Reporting List for Approval";
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
        $this->db->where('fdb.status_reporting',$this->config->item('LABEL_FDR_FORWARDED'));
        $this->db->group_by('fdb.id');
        $this->db->order_by('fdb.id','ASC');
        $items=$this->db->get()->result_array();

        foreach($items as &$item)
        {
            $item['date']=System_helper::display_date($item['date']);
            $item['expected_date']=System_helper::display_date($item['expected_date']);
            $item['total_budget']=number_format($item['total_budget'],2);
        }
        $this->jsonReturn($items);
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
        if(($this->locations['upazilla_id']>0)&&($this->locations['upazilla_id']!=$security['upazilla_id']))
        {
            return false;
        }
        return true;
    }

    private function system_details($id)
    {
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
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

            if($data['item_info']['status_reporting']=='Pending')
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_HAVE_TO_COMPLETE");
                $this->jsonReturn($ajax);
            }
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

            $data['report_item']=Query_helper::get_info($this->config->item('table_tm_fd_bud_reporting'),'*',array('budget_id ='.$budget_id));
            $user_ids=array();
            if($data['item_info']['user_report_approved']>0)
            {
                $user_ids[$data['item_info']['user_report_approved']]=$data['item_info']['user_report_approved'];
            }
            $info_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_info'),'*',array('budget_id='.$budget_id),0,0,array('id DESC','revision ASC'));
            $data['info_details']=array();;
            foreach($info_details as $info)
            {
                $data['info_details'][$info['revision']][]=$info;
                $user_ids[$info['user_created']]=$info['user_created'];
            }

            //get user info from login site
            $data['users_info']=System_helper::get_users_info($user_ids);

            $results=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array(),0,0,array('ordering ASC'));
            $data['expense_items']=array();
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
            $expense_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_expense'),'*',array('budget_id='.$budget_id),0,0,array('id ASC','revision ASC'));
            $data['expense_details']=array();
            foreach($expense_details as $expense)
            {
                $data['expense_details'][$expense['revision']][$expense['item_id']]=$expense;
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
            $participant_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_participant'),'*',array('budget_id='.$budget_id),0,0,array('id ASC','revision ASC'));
            $data['participant_details']=array();
            foreach($participant_details as $participant)
            {
                $data['participant_details'][$participant['revision']][$participant['farmer_id']]=$participant;
            }

            $data['file_details']=array();
            $data['video_file_details']=array();

            $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                if(substr($result['file_type'],0,5)=='image')
                {
                    $data['file_details'][]=$result;
                }
                elseif(substr($result['file_type'],0,5)=='video')
                {
                    $data['video_file_details']=$result;
                }
            }

            $data['title']='Completed Field Day Report';
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

    private function check_validation($participants,$expense_report)
    {
//        print_r($participants);
//        print_r($expense_report);exit;
        $expenses=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text','status'),array(),0,0,array('ordering ASC'));
        $farmers=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','CONCAT(name," (",phone_no,")") text','status'),array(),0,0,array('ordering ASC'));
        $fmr=array();

        foreach($farmers as $farmer)
        {
            $fmr[$farmer['value']]=$farmer['text'];
        }

        $expense=array();
        foreach($expenses as $exp)
        {
            $expense[$exp['value']]=$exp['text'];
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item[date]',$this->lang->line('LABEL_REPORTING_DATE'),'required');
        $this->form_validation->set_rules('item[date_of_fd]',$this->lang->line('LABEL_FIELD_DAY_DATE'),'required');
        $this->form_validation->set_rules('new_item[next_sales_target]',$this->lang->line('LABEL_NEXT_SALES_TARGET'),'required|numeric');
        $this->form_validation->set_rules('new_item[guest]',$this->lang->line('LABEL_GUEST'),'required|numeric');
        $this->form_validation->set_rules('new_item[participant_comment]',$this->lang->line('LABEL_PARTICIPANT_COMMENT'),'required');
        $this->form_validation->set_rules('new_item[participant_through_customer]',$this->lang->line('LABEL_PARTICIPANT_THROUGH_CUSTOMER'),'required');
        $this->form_validation->set_rules('new_item[participant_through_others]',$this->lang->line('LABEL_PARTICIPANT_THROUGH_OTHERS'),'required');
        $this->form_validation->set_rules('item[recommendation]',$this->lang->line('LABEL_RECOMMENDATION'),'required');
        if($expense_report)
        {
            foreach($expense_report as $index=>$exp)
            {
                if(!$exp)
                {
                    $this->form_validation->set_rules('expense_report['.$index.']',$expense[$index],'required');
                }
            }
        }
        if($participants)
        {
            foreach($participants as $index=>$id)
            {
                if(!$id)
                {
                    $this->form_validation->set_rules('farmers['.$index.']',$fmr[$index],'required');
                }
            }
        }
        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }

    private function system_approve($id)
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

            $data['report_item']=Query_helper::get_info($this->config->item('table_tm_fd_bud_reporting'),'*',array('budget_id ='.$budget_id));
            $user_ids=array();
            if($data['item_info']['user_report_approved']>0)
            {
                $user_ids[$data['item_info']['user_report_approved']]=$data['item_info']['user_report_approved'];
            }
            $info_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_info'),'*',array('budget_id='.$budget_id),0,0,array('id DESC','revision ASC'));
            $data['info_details']=array();;
            foreach($info_details as $info)
            {
                $data['info_details'][$info['revision']][]=$info;
                $user_ids[$info['user_created']]=$info['user_created'];
            }

            //get user info from login site
            $data['users_info']=System_helper::get_users_info($user_ids);

            $results=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array(),0,0,array('ordering ASC'));
            $data['expense_items']=array();
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
            $expense_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_expense'),'*',array('budget_id='.$budget_id),0,0,array('id ASC','revision ASC'));
            $data['expense_details']=array();
            foreach($expense_details as $expense)
            {
                $data['expense_details'][$expense['revision']][$expense['item_id']]=$expense;
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
            $participant_details=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_participant'),'*',array('budget_id='.$budget_id),0,0,array('id ASC','revision ASC'));
            $data['participant_details']=array();
            foreach($participant_details as $participant)
            {
                $data['participant_details'][$participant['revision']][$participant['farmer_id']]=$participant;
            }

            $data['file_details']=array();
            $data['video_file_details']=array();

            $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                if(substr($result['file_type'],0,5)=='image')
                {
                    $data['file_details'][]=$result;
                }
                elseif(substr($result['file_type'],0,5)=='video')
                {
                    $data['video_file_details']=$result;
                }
            }

            $data['title']='Approve or Reject This Field Day Report';
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/approve/'.$budget_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_save_approval()
    {
        $id = $this->input->post("id");
        $user = User_helper::get_user();
        if($id)
        {
            $data=array();
            $result=Query_helper::get_info($this->config->item('table_tm_fd_bud_budget'),'*',array('id ='.$id));
            foreach($result as $res)
            {
                $data=$res;
            }
            if($data['status_approved']=='Approved' || $data['status_approved']=='Rejected')
            {
                $this->message='Already '.$data['status_approved'];
                $this->system_list();
            }
        }
        if(!(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
        if(!$this->check_validation_approval())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        if($this->permissions['request_approve']!=1)
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
        else
        {
            $time=time();

            $data=$this->input->post('approve');
            $data['user_approved'] = $user->user_id;
            $data['date_approved'] = $time;
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

    private function check_validation_approval()
    {
        $data=$this->input->post('approve');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('approve[remarks_approved]',$this->lang->line('LABEL_RECOMMENDATION'),'required');
        if(!(($data['status_approved']==$this->config->item('system_status_po_request_approved'))||($data['status_approved']==$this->config->item('system_status_po_approval_rejected'))))
        {
            $this->message="Please Select Approve or Reject";
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