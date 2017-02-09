<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 1/26/17
 * Time: 3:27 PM
 */

class Tm_fd_bud_reporting extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Tm_fd_bud_reporting');
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
        $this->controller_url='tm_fd_bud_reporting';
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
        else
        {
            $this->system_list();
        }
    }

    private function system_list()
    {
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            $data['title']="Field Day Reporting List";
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
        $this->db->where('fdb.status_approved',$this->config->item('system_status_po_request_approved'));
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


//try....

    private function system_edit($id)
    {
        if(($this->input->post('id')))
        {
            $budgeted_id=$this->input->post('id');
        }
        else
        {
            $budgeted_id=$id;
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
        $this->db->where('fdb_details.budget_id',$budgeted_id);
        $this->db->where('fdb_details.revision',1);
        $data['item_info']=$this->db->get()->row_array();
        if(!$data['item_info'])
        {
            System_helper::invalid_try($this->config->item('system_edit_not_exists'),$budgeted_id);
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
        if(!$this->check_my_editable($data['item_info']))
        {
            System_helper::invalid_try($this->config->item('system_edit_others'),$budgeted_id);
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }

        $data['expense_items']=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $data['expense_budget']=array();
        $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_expense'),'*',array('budget_id ='.$budgeted_id,'revision=1'));
        foreach($results as $result)
        {
            $data['expense_budget'][$result['item_id']]=$result;
        }
        $data['expense_report']=array();

        $data['leading_farmers']=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','name text','phone_no phone_no'),array('status ="'.$this->config->item('system_status_active').'"','upazilla_id ='.$data['item_info']['upazilla_id']));
        $data['participants']=array();
        $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_participant'),'*',array('budget_id ='.$budgeted_id,'revision=1'));
        foreach($results as $res)
        {
            $data['participants'][$res['farmer_id']]=$res;
        }
        $data['farmers']=array();

        $data['file_details']=array();
        $data['video_file_details']['file_name']='';

        $result=Query_helper::get_info($this->config->item('table_tm_fd_bud_reporting'),'*',array('budget_id ='.$budgeted_id));
        if((isset($this->permissions['edit'])&&($this->permissions['edit']==1))&& $result)
        {
            foreach($result as $result)
            {
            $data['item']['date']=$result['date'];
            $data['item']['date_of_fd']=$result['date_of_fd'];
            $data['item']['recommendation']=$result['recommendation'];
            $data['item']['id']=$result['id'];
            $data['item']['budget_id']=$budgeted_id;
            }
            $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_expense'),'*',array('budget_id ='.$budgeted_id,'revision=1'));
            foreach($results as $res)
            {
                $data['expense_report'][$res['item_id']]=$res;
            }

            $this->db->from($this->config->item('table_tm_fd_rep_details_info').' fr_details');
            $this->db->select('fr_details.*');
            //$this->db->select('fbr.*');
            //$this->db->join($this->config->item('table_tm_fd_bud_reporting').' fbr','fbr.budget_id = fr_details.budget_id','INNER');
            $this->db->where('fr_details.budget_id',$budgeted_id);
            $this->db->where('fr_details.revision',1);
            $data['new_item']=$this->db->get()->row_array();
            //$data['item']['recommendation']=$data['new_item']['recommendation'];

            $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_participant'),'*',array('budget_id ='.$budgeted_id,'revision=1'));
            foreach($results as $res)
            {
                $data['farmers'][$res['farmer_id']]=$res;
            }

            $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_picture'),'*',array('budget_id ='.$budgeted_id,'revision=1'));
            foreach($results as $result)
            {
                if($result['file_type']=='Image')
                {
                    $data['file_details'][]=$result;
                }
                elseif($result['file_type']=='Video')
                {
                    $data['video_file_details']=$result;
                }
            }

            $data['title']='Editing Report On Field Day';
            $ajax['system_page_url']=site_url($this->controller_url."/index/edit/".$budgeted_id);
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $this->jsonReturn($ajax);

        }
        elseif(((isset($this->permissions['add'])&&($this->permissions['add']==1))||(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))&& !$result)
        {
            $data["item"] = Array(
                'id' => 0,
                'date' => time(),
                'date_of_fd' => '',
                'recommendation' => '',
                'budget_id' => $budgeted_id
            );
            $data["new_item"] = Array(
                'no_of_participant' => '',
                'guest' => '',
                'total_expense' => 0,
                'participant_comment' => '',
                'next_sales_target' => ''
            );
            $data['title']='Reporting On Field Day';
            $ajax['system_page_url']=site_url($this->controller_url."/index/edit/".$budgeted_id);
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("LABEL_NOT_EDITABLE");
            $this->jsonReturn($ajax);
        }
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
            $field_report=$this->input->post('item');
            $field_report['date']=System_helper::get_time($field_report['date']);
            $field_report['date_of_fd']=System_helper::get_time($field_report['date_of_fd']);
            $field_report_details=$this->input->post('new_item');
            $expense_report=$this->input->post('expense_report');
            $total_expense='';
            foreach($expense_report as &$exp_report)
            {
                if($exp_report=='')
                {
                    $exp_report=0;
                }
                $total_expense+=$exp_report;
            }
            $field_report_details['total_expense'] = $total_expense;
//            echo $total_expense;
//            print_r($expense_report);exit;
            $participants=$this->input->post('farmers');
            foreach($participants as &$no_of_participant)
            {
                if($no_of_participant=='')
                {
                    $no_of_participant=0;
                }
            }
            $budget_id=$field_report['budget_id'];
            $this->db->trans_begin();  //DB Transaction Handle START
            if($id>0)
            {
                $field_report['user_updated'] = $user->user_id;
                $field_report['date_updated'] = $time;
                Query_helper::update($this->config->item('table_tm_fd_bud_reporting'),$field_report,array("budget_id = ".$budget_id));
            }
            else
            {
                $field_report['user_created'] = $user->user_id;
                $field_report['date_created'] = $time;
                $report_id=Query_helper::add($this->config->item('table_tm_fd_bud_reporting'),$field_report);
                if($report_id===false)
                {
                    $this->db->trans_rollback();
                    $ajax['status']=false;
                    $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                    $this->jsonReturn($ajax);
                    die();
                }
                else
                {
                    $report_id=$report_id;
                }
            }
            //reporting details start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_rep_details_info'));
            $field_report_details['budget_id']=$budget_id;
            $field_report_details['revision']=1;
            $field_report_details['user_created'] = $user->user_id;
            $field_report_details['date_created'] = $time;
            Query_helper::add($this->config->item('table_tm_fd_rep_details_info'),$field_report_details);
            //reporting details end

            //expense details start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision','revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_rep_details_expense'));
            foreach($expense_report as $item_id=>$amount)
            {
                $data=array();
                $data['budget_id']=$budget_id;
                $data['item_id']=$item_id;
                $data['amount']=$amount;
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                $data['revision']=1;
                Query_helper::add($this->config->item('table_tm_fd_rep_details_expense'),$data);
            }
            //expense details end

            //participant though leading farmer details start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision','revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_rep_details_participant'));
            foreach($participants as $farmer_id=>$number)
            {
                $data=array();
                $data['budget_id']=$budget_id;
                $data['farmer_id']=$farmer_id;
                $data['number']=$number;
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                $data['revision']=1;
                Query_helper::add($this->config->item('table_tm_fd_rep_details_participant'),$data);
            }
            //participant though leading farmer details end

            //file details start
            $this->db->where('budget_id',$budget_id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_tm_fd_rep_details_picture'));
            $file_folder='images/field_day_reporting/'.$budget_id;
            $dir=(FCPATH).$file_folder;
            if(!is_dir($dir))
            {
                mkdir($dir, 0777);
            }
            //$types='gif|jpg|png|jpeg|wmv|mp4|mov|ftv|mkv|3gp';
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
            $files=$this->input->post('files');
            $remarks=$this->input->post('remarks');
            foreach($remarks as $index=>$remark)
            {
                if((isset($uploaded_files['file_'.$index])))
                {
                $exp=explode('.',$uploaded_files['file_'.$index]['info']['file_name']);
                $ext=strtolower($exp[sizeof($exp)-1]);
                }
                else
                {
                $exp=explode('.',$files[$index]);
                $ext=strtolower($exp[sizeof($exp)-1]);
                }
                if($ext=='gif' || $ext=='jpeg' || $ext=='jpg' || $ext=='png')
                {
                    $data=array();
                    $data['budget_id']=$budget_id;
                    if(isset($uploaded_files['file_'.$index]))
                    {
                        $data['file_location']=$file_folder.'/'.$uploaded_files['file_'.$index]['info']['file_name'];
                        $data['file_name']=$uploaded_files['file_'.$index]['info']['file_name'];
                    }
                    else
                    {
                        $data['file_location']=$file_folder.'/'.$files[$index];
                        $data['file_name']=$files[$index];
                    }
                    $data['file_remarks']=$remark;
                    $data['file_type']='Image';
                    $data['user_created'] = $user->user_id;
                    $data['date_created'] = $time;
                    $data['revision']=1;
                    Query_helper::add($this->config->item('table_tm_fd_rep_details_picture'),$data);
                }
                else
                {
                    $this->db->trans_rollback();
                    $ajax['status']=false;
                    $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                    $this->jsonReturn($ajax);
                }
            }
            $data=array();
            $video_file=$this->input->post('video_file');
            if((isset($uploaded_files['video'])))
            {
                $exp=explode('.',$uploaded_files['video']['info']['file_name']);
                $ext=strtolower($exp[sizeof($exp)-1]);
            }
            else
            {
                $exp=explode('.',$video_file);
                $ext=strtolower($exp[sizeof($exp)-1]);
            }
            if($ext=='mkv' || $ext=='ftv' || $ext=='mov' || $ext=='mp4' || $ext=='3gp' || $ext=='wmv')
            {
                if(isset($uploaded_files['video']))
                {
                    $data['file_location']=$file_folder.'/'.$uploaded_files['video']['info']['file_name'];
                    $data['file_name']=$uploaded_files['video']['info']['file_name'];
                }
                else
                {
                    $data['file_location']=$file_folder.'/'.$video_file;
                    $data['file_name']=$video_file;
                }
                $data['budget_id']=$budget_id;
                $data['file_type']='Video';
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                $data['revision']=1;
                Query_helper::add($this->config->item('table_tm_fd_rep_details_picture'),$data);
            }
            else
            {
                $this->db->trans_rollback();
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }

            //file details END
            //status_reporting start
            $this->db->where('id',$budget_id);
            $this->db->set('status_reporting','Complete');
            $this->db->update($this->config->item('table_tm_fd_bud_budget'));
            //status_reporting end

            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
                $this->system_list();
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
            $this->db->from($this->config->item('table_tm_fd_rep_details_info').' frd');
            $this->db->select('frd.*');
            $this->db->where('frd.budget_id',$budget_id);
            $this->db->order_by('frd.revision ASC');
            $this->db->order_by('frd.id DESC');
            $info_details=$this->db->get()->result_array();
            $data['info_details']=array();
            foreach($info_details as $info)
            {
                $data['info_details'][$info['revision']][]=$info;
                $user_ids[$info['user_created']]=$info['user_created'];
            }
            //get user info from login site
            $data['users_info']=System_helper::get_users_info($user_ids);
//            echo '<pre>';
//            print_r($data['info_details']);
//            echo '</pre>';exit;

            $data['expense_items']=Query_helper::get_info($this->config->item('table_setup_fd_bud_expense_items'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['expense_budget']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_expense'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                $data['expense_budget'][$result['item_id']]=$result;
            }
            $this->db->from($this->config->item('table_tm_fd_rep_details_expense').' frde');
            $this->db->select('frde.*');
            $this->db->where('frde.budget_id',$budget_id);
            $this->db->order_by('frde.revision ASC');
            $this->db->order_by('frde.id DESC');
            $expense_details=$this->db->get()->result_array();
            $data['expense_details']=array();
            foreach($expense_details as $expense)
            {
                $data['expense_details'][$expense['revision']][]=$expense;
            }
//            echo '<pre>';
//            print_r($data['expense_details']);
//            echo '</pre>';exit;

            $data['leading_farmers']=Query_helper::get_info($this->config->item('table_setup_fsetup_leading_farmer'),array('id value','name text','phone_no phone_no'),array('status ="'.$this->config->item('system_status_active').'"','upazilla_id ='.$data['item_info']['upazilla_id']));
            $data['participants']=array();
            $results=Query_helper::get_info($this->config->item('table_tm_fd_bud_details_participant'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $res)
            {
                $data['participants'][$res['farmer_id']]=$res;
            }
            $this->db->from($this->config->item('table_tm_fd_rep_details_participant').' frdp');
            $this->db->select('frdp.*');
            $this->db->where('frdp.budget_id',$budget_id);
            $this->db->order_by('frdp.revision ASC');
            $this->db->order_by('frdp.id ASC');
            $participant_details=$this->db->get()->result_array();
            $data['participant_details']=array();
            foreach($participant_details as $participant)
            {
                $data['participant_details'][$participant['revision']][]=$participant;
            }
//            echo '<pre>';
//            print_r($data['participant_details']);
//            echo '</pre>';exit;

            $data['file_details']=array();
            $data['video_file_details']=array();

            $results=Query_helper::get_info($this->config->item('table_tm_fd_rep_details_picture'),'*',array('budget_id ='.$budget_id,'revision=1'));
            foreach($results as $result)
            {
                if($result['file_type']=='Image')
                {
                    $data['file_details'][]=$result;
                }
                elseif($result['file_type']=='Video')
                {
                    $data['video_file_details']=$result;
                }
            }

            $data['title']='Field Day Reporting Details';
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

    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item[date]',$this->lang->line('LABEL_DATE'),'required');
        $this->form_validation->set_rules('new_item[next_sales_target]',$this->lang->line('LABEL_NEXT_SALES_TARGET'),'required|numeric');
        $this->form_validation->set_rules('new_item[guest]',$this->lang->line('LABEL_GUEST'),'required|numeric');
        $this->form_validation->set_rules('new_item[participant_comment]',$this->lang->line('LABEL_PARTICIPANT_COMMENT'),'required');
        $this->form_validation->set_rules('new_item[no_of_participant]',$this->lang->line('LABEL_EXPECTED_PARTICIPANT'),'required|numeric');
        $this->form_validation->set_rules('item[recommendation]',$this->lang->line('LABEL_RECOMMENDATION'),'required');
        $this->form_validation->set_rules('farmers[]',$this->lang->line('LABEL_PARTICIPANT_THROUGH_LEAD_FARMER'),'required');
        $this->form_validation->set_rules('expense_report[]',$this->lang->line('LABEL_FIELD_DAY_BUDGET'),'required');

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }

}