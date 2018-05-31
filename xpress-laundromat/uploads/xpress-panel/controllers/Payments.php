<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payments extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->users->_valid_user();
    }
    
    function index()
    {
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('coupon','Coupon Code','trim|xss_clean');
        if($this->form_validation->run())
        {
            
            $amount = $this->input->post('amount');
            $pagedata['userdata'] = $this->users->get_user('id,firstname,email_id,phone_no',$this->session->user_id);
            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            
                $pagedata['key']=KEY;
                $hash = HASH;
                $pagedata['payment_method']='payu_paisa';
                $posted = [];
                $productinfo = 'Recharge';
                $posted = ['key'=>$pagedata['key'],'txnid'=>$txnid,'amount'=>$amount,'productinfo'=>$productinfo,
                    'firstname'=>$pagedata['userdata']->firstname,'email'=>$pagedata['userdata']->email_id,'udf1'=>$pagedata['userdata']->id,
                    'udf2'=> '','udf3'=>  '','udf4'=>  ''];
                $hashSequence =     "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';  
                foreach($hashVarsSeq as $hash_var) {
                  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                  $hash_string .= '|';
                }

                $hash_string .= $hash;
                $pagedata['hash'] = strtolower(hash('sha512', $hash_string));
                $pagedata['txn']=$txnid;
                $pagedata['hash_s'] = $hash_string;
                $pagedata['order_detail'] = ['pro_info'=>  $productinfo,'amount'=>$amount];
//                echo "<pre>";
//                print_r($pagedata);die;
                $this->load->view('home/payment_vw',$pagedata);
            
        }else{
            redirect('home');
        }
    }
    
    function success_payment()
    {
        if($this->input->post('status')=='success')
        {
            $created = strtotime($this->input->post('addedon'));
            $val = ['mihpayid' => $this->input->post('mihpayid'),'transcation_id'=>  $this->input->post('txnid'),'amount'=>  $this->input->post('amount'),
               'user_id'=>  $this->input->post('udf1'),'payment_method'=>'Payu','recharge_by'=>  0,'payment_status'=>1,'created'=>$created];
            
            $verify = ['val'=>'id','table'=>'tbl_transcations','where'=>['transcation_id'=>$this->input->post('txnid')]];
            $res = $this->common->get_verify($verify);
            if(!$res['res'])
            {
                $data = ['val'=>$val,'table'=>'tbl_transcations'];
                $this->common->add_data($data);
                $balance = $this->users->get_user('wallet_balance',$this->session->user_id);
                $amount = $this->input->post('amount') + $balance->wallet_balance;
                $this->londury->update_wallet($amount);
            }
            redirect('home');
        }else{
            redirect('home');
        }
    }    
    
    function fail_payment()
    {
        if($this->input->post('status')=='failure')
        {
            $created = strtotime($this->input->post('addedon'));
            
                $val = ['mihpayid' => $this->input->post('mihpayid'),'transcation_id'=>  $this->input->post('txnid'),'amount'=>  $this->input->post('amount'),
               'user_id'=>  $this->input->post('udf1'),'recharge_by'=>  0,'payment_status'=>2,'payment_method'=>'Payu','fail_reason'=>  $this->input->post('field9'),'created'=>$created];
            $verify = ['val'=>'id','table'=>'tbl_transcations','where'=>['transcation_id'=>$this->input->post('txnid')]];
            $res = $this->common->get_verify($verify);
            if(!$res['res'])
            {
                $data = ['val'=>$val,'table'=>'tbl_transcations'];
                $this->common->add_data($data);
            }
            $pagedata['details'] = $this->users->get_user('firstname,wallet_balance',  $this->session->user_id);
            $pagedata['title'] = 'Payment Failed';
            $pagedata['resp'] = $this->input->post();
            $this->load->view('header_vw',$pagedata);
            $this->load->view('home/failpayment_vw');
            $this->load->view('footer_vw');
            
        }else{
            redirect('home');
        }
    }
    
    
}