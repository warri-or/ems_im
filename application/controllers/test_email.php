<?php

class test_email extends CI_Controller {

    public function index()
    {
        $data=array();
        $data['from']='program3@gmail.com';
        $data['to'][]='program3@malikseeds.com';
        //$data['to'][]='program3@malikseeds.com';

//        $data['attachments'][0]=FCPATH.'images/field_day_reporting/1/nun.JPG';
//        $data['attachments'][1]=FCPATH.'images/field_day_reporting/1/quick_star.JPG';
        $data['header']='';
        $data['message']='test email';
        //$data['message']=$this->load->view('html_message_for_mail');
        $data['name']='';

        $this->send_email($data);
    }

    public function send_email($mail_data)
    {

        if(isset($mail_data['to']) && isset($mail_data['message']))
        {
            $this->load->library('email');
            $config['protocol'] = 'mail';
            $config['smtp_host'] = '216.172.184.107';
            $config['smtp_user'] = 'program3@malikseeds.com';
            $config['smtp_pass'] = 'MALIK4321';
            $config['smtp_port'] = '465';
            $this->email->initialize($config);
            if(!isset($mail_data['from']))
            {
                $mail_data['from']='info@malikseeds.com';
            }
            if(!isset($mail_data['name']))
            {
                $mail_data['name']='Unknown';
            }
            $this->email->from($mail_data['from'],$mail_data['name']);
            $this->email->to($mail_data['to']);
            if(isset($mail_data['cc']))
            {
                $this->email->cc($mail_data['cc']);
            }
            if(isset($mail_data['bcc']))
            {
                $this->email->bcc($mail_data['bcc']);
            }
            if(!isset($mail_data['header']))
            {
                $mail_data['header']='Subject Not Found';
            }
            $this->email->subject($mail_data['header']);
           // $this->email->message($this->load->view('html_message_for_mail/'.$type.'-html', $data, TRUE));
            $this->email->message($this->load->view('html_message_for_mail','',true));
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            if(isset($mail_data['attachments']))
            {
                foreach($mail_data['attachments'] as $attach)
                {
                    $this->email->attach($attach);
                }
            }
            if($this->email->send())
            {
                echo "Mail Sent Successfully";
            }
            else
            {
                echo "Sending failed";
            }
        }
        else
        {
            echo 'Receipients Detail or Mail Information Not Found.';
        }
    }
}