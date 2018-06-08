<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->users->_valid_user();
    }
    
    function index()
    {
        $pagedata['details'] = $this->londury->get_user_detail();
        $pagedata['title'] = 'My Account';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('user/profile_vw');
        $this->load->view('footer_vw');
    }
    
    function edit_profile()
    {
        $pagedata['details'] = $this->londury->get_user_detail();
        $pagedata['title'] = 'Edit Account';
        $pagedata['colleges'] = $this->db->get_where('tbl_college',['status'=>1])->result();
        $this->load->view('header_vw',$pagedata);
        $this->load->view('user/editprofile_vw');
        $this->load->view('footer_vw');
    }
    
    function update_profile()
    {
        $udata = $this->users->get_user('phone_no',  $this->session->user_id);
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|alpha_numeric_spaces|xss_clean');
        //$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha_numeric_spaces|xss_clean');
        //$this->form_validation->set_rules('dob', 'Birthday', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        if($udata->phone_no!=$this->input->post('phonenumber'))
        {
        $this->form_validation->set_rules('phonenumber', 'Phone No', 'trim|required|xss_clean|is_unique[tbl_users.phone_no]');
        }else{
            $this->form_validation->set_rules('phonenumber', 'Phone No', 'trim|required|xss_clean');
        }
//        $this->form_validation->set_rules('college_id', 'College', 'trim|required|xss_clean');
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('roomnumber', 'Room Number', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('rollnumber', 'Roll Number', 'trim|required|xss_clean');
        $this->form_validation->set_message('is_unique', 'The %s already taken, Try another.');
        if($this->form_validation->run())
        {
            $val=['firstname'=>$this->input->post('firstname'),'hostel_id'=>  $this->input->post('hostel_id'),
                'phone_no'=>  $this->input->post('phonenumber')];
            $data=['val'=>$val,'table'=>'tbl_users','where'=>['id'=>  $this->session->user_id]];
            $this->common->update_data($data);
            
            echo json_encode(['status'=>TRUE,'rdir'=>'user']);
        }else{
            $error = ['firstname_err'=>  form_error('firstname','<div class="err">','</div>'),'emailid_err'=>form_error('emailid','<div class="err">','</div>'),
                'phonenumber_err'=>form_error('phonenumber','<div class="err">','</div>'),'college_id_err'=>form_error('college_id','<div class="err">','</div>'),
                'hostel_id_err'=>form_error('hostel_id','<div class="err">','</div>'),'password_err'=>form_error('password','<div class="err">','</div>'),
                'cpassword_err'=>form_error('cpassword','<div class="err">','</div>'),'terms_err'=>form_error('terms','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function upload_profile()
    {
        $this->users->_valid_user();
        $data=$this->functions->_upload_image('file','assets/img/profiles/'.$this->session->user_id.'/','jpg|jpeg|png','5000');
        if($data['status'])
        {
                $update=['val'=>['profile_pic'=>BASE.'assets/img/profiles/'.$this->session->user_id.'/'.$data['filename']],'table'=>'tbl_users','where'=>['id'=>$this->session->user_id]];
                $this->common->update_data($update);
                echo json_encode(['status'=>TRUE,'data'=>BASE.'assets/img/profiles/'.$this->session->user_id.'/'.$data['filename']]);
        }else{
            if($data['error']==''){$data['error']='Please select a file.';}
            echo json_encode(['status'=>FALSE,'data'=>$data['error']]);
        }
    }
    
    function settings()
    {
        $this->users->_valid_user();
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[20]|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
        if($this->form_validation->run())
        {
            $verify=array('val'=>'id','where'=>array('password'=>  md5($this->input->post('current_password')),'id'=>  $this->session->user_id),'table'=>'tbl_users');
            $res=$this->common->get_verify($verify);
            if($res['res'])
            {
                $data=array('val'=>array('password'=>md5($this->input->post('new_password'))),'where'=>array('id'=>  $this->session->user_id),'table'=>'tbl_users');
                if($this->common->update_data($data))
                {
                    $this->session->set_flashdata('msg','Password has been successfully changed.');
                    redirect('home');
                }
                
            }else{
                $this->session->set_flashdata('error','You entered wrong password.');
                redirect('user/settings');
            }
        }
        $pagedata['details'] = $this->users->get_user('wallet_balance',$this->session->user_id);
        $pagedata['title']='Change password';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('user/change_password_vw');
        $this->load->view('footer_vw');
    }
}
