<?php
class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('functions');
    }
    
    function _is_logged()
    {
        if($this->session->admin_id)
        {
            redirect('panel/home/','refresh');
        }
    }
    
    function _login($username,$password)
    {
        $data=array('val'=>'id,user_type,college_id','table'=>'tbl_admin','where'=>array('email'=>strtolower($username),'password'=>$password,'status'=>'1'));
        $log= $this->common->signin($data);
        if($log['res'])
        {
            $this->session->unset_userdata('user_id');
           $this->session->set_userdata('admin_id', $log['rows']->id);
           $this->session->set_userdata('user_type', $log['rows']->user_type);
           $this->session->set_userdata('a_college_id', $log['rows']->college_id);
           return true;
        }
        else{
            return false;
        }
    }

    function wallet_log_check()
    {
        $res = $this->db->query('SELECT * FROM tbl_wallet_log ORDER BY `time` DESC ');
        foreach( $res->result() as $con)
        {
            echo $con->content.'<br>';
        }
    }
    
    function index()
    {
        $this->_is_logged();
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
            if($this->_login($this->input->post('email'),($this->input->post('password'))))              // md5
            {
                if($this->input->post('remember')=='remember')
                {
                    $this->load->helper('cookie');
                    $cookie = array(
                                'name'   => 'GFu',
                                'value'  => base64_encode(trim($this->input->post('email'))),
                                'expire' => time()+3600
                            );
                    $cookie2 = array(
                                'name'   => 'GFp',
                                'value'  => base64_encode($this->input->post('password')),
                                'expire' => time()+3600
                            );
                    $this->input->set_cookie($cookie);
                    $this->input->set_cookie($cookie2);
                }
                else
                {
                    $this->load->helper('cookie');
                    delete_cookie("GFu");delete_cookie("GFp");
                }
                redirect(BASE.'panel/home/', 'refresh');
            }else
            {
                $this->session->set_flashdata('err','Invalid Username/Password.');
                redirect('/panel','refresh');
            }
        }
        $pagedata['title']='Admin Login';
        $pagedata['error']=  $this->session->flashdata('err');
        $pagedata['msg']=  $this->session->flashdata('msg');
        $this->load->view('panel/auth/header',$pagedata);
        $this->load->view('panel/auth/login');
        $this->load->view('panel/auth/footer');
    }
    
    function forgot_password() 
    {
        $this->_is_logged();
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        if($this->form_validation->run() == false)
        {
            $pagedata['error']=  $this->session->flashdata('err');
            $pagedata['title'] = 'Forgot Password - Poolwallet';
            
            $this->load->view('panel/auth/header',$pagedata);
            $this->load->view('panel/auth/forgot');
            $this->load->view('panel/auth/footer');
            
        }
        else
        {
            $data=array('val'=>'id','table'=>'tbl_admin','where'=>array('email'=>$this->input->post('email')));
                //run the forgotten password method to email an activation code to the user
            $forgotten = $this->common->get_verify($data);
            if($forgotten['res'])
            {
                $code=substr(md5(rand(000,9999)),5,6);
                $message="Hello User<br>Your Password reset code is <b>$code</b>";
                $email=array('to'=>$this->input->post('email'),'message'=>$message,'subject'=>'Reset password code');
                if($this->functions->_email($email))
                {
                    $new_data=array('val'=>array('forgot_code'=>$code),'where'=>array('email'=>$this->input->post('email')),'table'=>'tbl_admin');
                    if($this->common->update_data($new_data))
                    {
                    $this->session->set_userdata('verify',$this->input->post('email'));
                    redirect('panel/auth/verify-code', 'refresh');
                    }
                }
             }else
             {
                $this->session->set_flashdata('err','Email not exist.');
                redirect(BASE."panel/auth/forgot-password", 'refresh');
             }
        }
    }
    
    function verify_code()
    {
        $this->_is_logged();
        if($this->session->userdata('verify'))
        {
            $this->form_validation->set_rules('code', 'Verification Code', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $pagedata['error']= $this->session->flashdata('err');
                $pagedata['title'] = 'Verify Code ';
                $this->load->view('panel/auth/header',$pagedata);
                $this->load->view('panel/auth/verify');
                $this->load->view('panel/auth/footer');
            }else{
                $data=array('val'=>'id','where'=>array('email'=>$this->session->userdata('verify'),'forgot_code'=>$this->input->post('code')),'table'=>'tbl_admin');
                $res=$this->common->get_verify($data);
                if($res['res'])
                {
                    $new_data=array('val'=>array('forgot_code'=>'0'),'where'=>array('email'=>$this->session->userdata('verify')),'table'=>'tbl_admin');
                    if($this->common->update_data($new_data))
                    {
                        $this->session->set_userdata('reset',$this->session->userdata('verify'));
                        $this->session->unset_userdata('verify');
                        redirect(BASE."panel/auth/reset-password", 'refresh');

                    }
                }else{
                    $this->session->set_flashdata('err','Invalid code,Please try again with valid code.');
                    redirect(BASE."panel/auth/verify-code", 'refresh');
                }
            }
        }else{
          redirect('panel/','refresh');
        }
    }
        
    function resend()
    {
        $this->_is_logged();
        if($this->session->userdata('verify'))
        {
            $code=substr(md5(rand(000,9999)),5,6);
            $message="Hello User<br>Your Password reset code is <b>$code</b>";
            $email=array('to'=>$this->session->userdata('verify'),'message'=>$message,'subject'=>'Reset password code');
            if($this->functions->_email($email))
            {
                $new_data=array('val'=>array('forgot_code'=>$code),'where'=>array('email'=>$this->session->userdata('verify')),'table'=>'users');
                if($this->common->update_data($new_data))
                {
                    $this->session->set_flashdata('err','New code sent to your registered mail id.');
                    redirect('panel/auth/verify-code', 'refresh');
                }
            }
        }else{
          redirect('panel','refresh');
        }
    }
        
    function reset_password()
    {
        $this->_is_logged();
       if($this->session->userdata('reset'))
        {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
            if($this->form_validation->run() == false)
            {
                $pagedata['title'] = 'Reset Password';
                $this->load->view('panel/auth/header',$pagedata);
                $this->load->view('panel/auth/reset-password');
                $this->load->view('panel/auth/footer');

            }
            else{

                    $new_data=array('val'=>array('password'=>md5($this->input->post('password'))),'where'=>array('email'=>$this->session->userdata('reset')),'table'=>'tbl_admin');
                    $this->common->update_data($new_data);
                    $message="Hello User<br>Your Password has been successfully changed.";
                    $email=array('to'=>$this->session->userdata('reset'),'message'=>$message,'subject'=>'Password Changed Successfully');
                    if($this->functions->_email($email))
                    {
                        $this->session->unset_userdata('reset');
                        $this->session->set_flashdata('msg','Password Successfully changed, Please Login with new password.');
                        redirect(BASE."panel/auth/", 'refresh');
                    }
            }
        }else{
          redirect('panel/','refresh');
        }
    }
    
    function logout()
    {
        $this->session->sess_destroy();
        redirect('panel/auth','refresh');
    }
}
