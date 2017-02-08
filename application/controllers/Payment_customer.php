<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_customer extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Payment_customer');
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
        $this->controller_url='payment_customer';
        //$this->load->model("sys_module_task_model");
    }

    public function index($action="list",$id=0)
    {
        if($action=="list")
        {
            $this->system_list($id);
        }
        elseif($action=="add")
        {
            $this->system_add();
        }
        elseif($action=="edit")
        {
            $this->system_edit($id);
        }
        elseif($action=="details")
        {
            $this->system_details($id);
        }
        elseif($action=="delete")
        {
            $this->system_delete();
        }
        elseif($action=="save")
        {
            $this->system_save();
        }
        else
        {
            $this->system_list($id);
        }
    }

    private function system_list()
    {
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            $data['title']="Payment List";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("payment_customer/list",$data,true));
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

    private function system_add()
    {
        if(isset($this->permissions['add'])&&($this->permissions['add']==1))
        {
            $data['title']="Create New Payment";
            $data["payment"] = Array(
                'id' => 0,
                'division_id'=>$this->locations['division_id'],
                'zone_id'=>$this->locations['zone_id'],
                'territory_id'=>$this->locations['territory_id'],
                'district_id'=>$this->locations['district_id'],
                'customer_id'=>'',
                'payment_way' => '',
                'amount_customer' => '0',
                'cheque_no' => '',
                'bank_id' => '',
                'bank_branch' => '',
                'date_payment_customer' => time(),
                'credit'=>0
            );
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
                            $data['customers']=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','CONCAT(customer_code," - ",name) text'),array('district_id ='.$data['adjust']['district_id'],'status ="'.$this->config->item('system_status_active').'"'));
                        }
                    }
                }
            }
            $data['banks']=Query_helper::get_info($this->config->item('table_basic_setup_bank'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));

            $ajax['system_page_url']=site_url($this->controller_url."/index/add");

            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("payment_customer/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_edit($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $payment_id=$this->input->post('id');
            }
            else
            {
                $payment_id=$id;
            }

            $this->db->from($this->config->item('table_payment_payment').' payment');
            $this->db->select('payment.*');
            $this->db->select('CONCAT(cus.customer_code," - ",cus.name) customer_name');
            $this->db->select('cus.id customer_id');
            $this->db->select('d.name district_name,d.id district_id');
            $this->db->select('t.name territory_name,t.id territory_id');
            $this->db->select('zone.name zone_name,zone.id zone_id');
            $this->db->select('division.name division_name,division.id division_id');
            $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = payment.customer_id','INNER');
            $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
            $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
            $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
            $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');
            $this->db->where('payment.id',$payment_id);
            $data['payment']=$this->db->get()->row_array();
            if(!$data['payment'])
            {
                System_helper::invalid_try($this->config->item('system_edit_not_exists'),$payment_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if(!$this->check_my_editable($data['payment']))
            {
                System_helper::invalid_try($this->config->item('system_edit_others'),$payment_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }


            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['zones']=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('division_id ='.$data['payment']['division_id']));
            $data['territories']=Query_helper::get_info($this->config->item('table_setup_location_territories'),array('id value','name text'),array('zone_id ='.$data['payment']['zone_id']));
            $data['districts']=Query_helper::get_info($this->config->item('table_setup_location_districts'),array('id value','name text'),array('territory_id ='.$data['payment']['territory_id']));
            $data['customers']=Query_helper::get_info($this->config->item('table_csetup_customers'),array('id value','CONCAT(customer_code," - ",name) text'),array('district_id ='.$data['payment']['district_id'],'status ="'.$this->config->item('system_status_active').'"'));

            $data['banks']=Query_helper::get_info($this->config->item('table_basic_setup_bank'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $this->load->model("sales_model");
            $balance=$this->sales_model->get_customer_current_credit($data['payment']['customer_id']);
            $data['payment']['credit']=$balance['tp'];


            $data['title']="Edit Payment";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("payment_customer/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$payment_id);
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
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            if(($this->input->post('id')))
            {
                $payment_id=$this->input->post('id');
            }
            else
            {
                $payment_id=$id;
            }

            $this->db->from($this->config->item('table_payment_payment').' payment');
            $this->db->select('payment.*');
            $this->db->select('CONCAT(cus.customer_code," - ",cus.name) customer_name');
            $this->db->select('d.name district_name,d.id district_id');
            $this->db->select('t.name territory_name,t.id territory_id');
            $this->db->select('zone.name zone_name,zone.id zone_id');
            $this->db->select('division.name division_name,division.id division_id');
            $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = payment.customer_id','INNER');
            $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
            $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
            $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
            $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');
            $this->db->where('payment.id',$payment_id);
            $data['payment']=$this->db->get()->row_array();
            if(!$data['payment'])
            {
                System_helper::invalid_try($this->config->item('system_view_not_exists'),$payment_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            if(!$this->check_my_editable($data['payment']))
            {
                System_helper::invalid_try($this->config->item('system_view_others'),$payment_id);
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
            }
            $data['banks']=Query_helper::get_info($this->config->item('table_basic_setup_bank'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['arm_banks']=Query_helper::get_info($this->config->item('table_basic_setup_arm_bank'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['arm_bank_accounts']=array();
            if($data['payment']['arm_bank_id']>0)
            {
                $data['arm_bank_accounts']=Query_helper::get_info($this->config->item('table_basic_setup_arm_bank'),array('id value','name text'),array('bank_id'=>$data['payment']['arm_bank_id'],'status ="'.$this->config->item('system_status_active').'"'));
            }
            $user_ids=array();
            $user_ids[$data['payment']['user_created']]=$data['payment']['user_created'];
            if($data['payment']['user_receive']>0)
            {
                $user_ids[$data['payment']['user_receive']]=$data['payment']['user_receive'];
            }
            $data['users']=System_helper::get_users_info($user_ids);

            $data['title']="Details of Payment";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("payment_customer/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$payment_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_delete()
    {
        if(isset($this->permissions['delete'])&&($this->permissions['delete']==1))
        {
            $ids = $this->input->post("ids");
            $user = User_helper::get_user();
            $this->db->trans_start();  //DB Transaction Handle START
            $time=time();
            foreach($ids as $id)
            {
                Query_helper::update($this->config->item('table_payment_payment'),array('status'=>$this->config->item('system_status_delete'),'user_updated'=>$user->user_id,'date_updated'=>$time),array("id = ".$id));
            }
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
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
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
            $data=$this->input->post('payment');
            $data['date_payment_customer']=System_helper::get_time($data['date_payment_customer']);
            $this->db->trans_start();  //DB Transaction Handle START
            if($id>0)
            {
                $data['user_updated'] = $user->user_id;
                $data['date_updated'] = time();

                Query_helper::update($this->config->item('table_payment_payment'),$data,array("id = ".$id));

            }
            else
            {

                $data['user_created'] = $user->user_id;
                $data['date_created'] = time();
                Query_helper::add($this->config->item('table_payment_payment'),$data);
            }
            $this->db->trans_complete();   //DB Transaction Handle END
            if ($this->db->trans_status() === TRUE)
            {
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
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }
        }
    }
    private function check_my_editable($customer)
    {
        if(($this->locations['division_id']>0)&&($this->locations['division_id']!=$customer['division_id']))
        {
            return false;
        }
        if(($this->locations['zone_id']>0)&&($this->locations['zone_id']!=$customer['zone_id']))
        {
            return false;
        }
        if(($this->locations['territory_id']>0)&&($this->locations['territory_id']!=$customer['territory_id']))
        {
            return false;
        }
        if(($this->locations['district_id']>0)&&($this->locations['district_id']!=$customer['district_id']))
        {
            return false;
        }
        return true;
    }
    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('payment[customer_id]',$this->lang->line('LABEL_CUSTOMER_NAME'),'required');
        $this->form_validation->set_rules('payment[amount_customer]',$this->lang->line('LABEL_AMOUNT'),'required|numeric');
        $this->form_validation->set_rules('payment[date_payment_customer]',$this->lang->line('LABEL_DATE_PAYMENT'),'required');
        $this->form_validation->set_rules('payment[payment_way]',$this->lang->line('LABEL_PAYMENT_WAY'),'required');
        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        $id=$this->input->post('id');
        if($id>0)
        {
            $this->db->from($this->config->item('table_payment_payment').' payment');
            $this->db->select('payment.*');
            $this->db->select('cus.name');
            $this->db->select('d.name district_name,d.id district_id');
            $this->db->select('t.name territory_name,t.id territory_id');
            $this->db->select('zone.name zone_name,zone.id zone_id');
            $this->db->select('division.name division_name,division.id division_id');
            $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = payment.customer_id','INNER');
            $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
            $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
            $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
            $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');
            $this->db->where('payment.id',$id);

            $payment=$this->db->get()->row_array();


            if(!$payment)
            {
                System_helper::invalid_try($this->config->item('system_save'),$id,'Hack trying to edit an id that does not exits');
                $this->message="Invalid Try";
                return false;
            }
            if(!$this->check_my_editable($payment))
            {
                System_helper::invalid_try($this->config->item('system_save'),$id,'Hack To edit other customer that does not in my area');
                $this->message="Invalid Try";
                return false;
            }
        }

        $data=$this->input->post('payment');
        $this->db->from($this->config->item('table_setup_location_districts').' d');
        $this->db->select('d.id district_id');
        $this->db->select('t.id territory_id');
        $this->db->select('zone.id zone_id');
        $this->db->select('zone.division_id division_id');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.district_id = d.id','INNER');
        $this->db->where('cus.id',$data['customer_id']);
        $info=$this->db->get()->row_array();
        if(!$this->check_my_editable($info))
        {
            $this->message="Invalid Try";
            System_helper::invalid_try($this->config->item('system_save'),$id,'Hack To assign other district that does not belong to me.');
            return false;
        }


        return true;
    }
    public function get_items()
    {
        $this->db->from($this->config->item('table_payment_payment').' payment');
        $this->db->select('payment.id,payment.amount,payment.amount_customer,payment.payment_way,payment.date_payment_customer,payment.date_payment_receive,payment.cheque_no');
        $this->db->select('CONCAT(cus.customer_code," - ",cus.name) customer_name');
        $this->db->select('d.name district_name');
        $this->db->select('t.name territory_name');
        $this->db->select('zone.name zone_name');
        $this->db->select('division.name division_name');
        $this->db->join($this->config->item('table_csetup_customers').' cus','cus.id = payment.customer_id','INNER');
        $this->db->join($this->config->item('table_setup_location_districts').' d','d.id = cus.district_id','INNER');
        $this->db->join($this->config->item('table_setup_location_territories').' t','t.id = d.territory_id','INNER');
        $this->db->join($this->config->item('table_setup_location_zones').' zone','zone.id = t.zone_id','INNER');
        $this->db->join($this->config->item('table_setup_location_divisions').' division','division.id = zone.division_id','INNER');
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
                    }
                }
            }
        }
        $this->db->where('payment.status !=',$this->config->item('system_status_delete'));
        $this->db->order_by('payment.id','DESC');
        $items=$this->db->get()->result_array();
        foreach($items as &$item)
        {
            $item['date_payment_customer']=System_helper::display_date($item['date_payment_customer']);
            if($item['date_payment_receive']>0)
            {
                $item['date_payment_receive']=System_helper::display_date($item['date_payment_receive']);
                $item['status_receive']='Received';
            }
            else
            {
                $item['date_payment_receive']='';
                $item['status_receive']='Pending';
            }
            $item['amount_customer']=number_format($item['amount_customer'],2);
            if($item['amount']>0)
            {
                $item['amount']=number_format($item['amount'],2);
            }
            $item['payment_id']=str_pad($item['id'],6,'0',STR_PAD_LEFT);
        }
        $this->jsonReturn($items);
    }

}
